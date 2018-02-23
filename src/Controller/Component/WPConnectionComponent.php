<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Automattic\WooCommerce\Client as WooClient;

/**
 * WPConnection component
 */
class WPConnectionComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
 
    function requestData($data) {
        if (isset($this->requestData[$data])) return $this->requestData[$data];
        return false;
    }

    public function startup(Event $event) {
        
        //Configuramos el cliente HTTP
        $this->http = new Client();

        //Obtenemos los datos de la request.
        $this->requestData = $this->request->getData();
        
        //Configuramos los objetos y modelos que se van a utilizar.
        $this->ConfigModel = TableRegistry::get('Config');
        $this->ApiModel = TableRegistry::get('Apikey');
        $this->CustomersModel = TableRegistry::get('Customers');
        $this->PaymentsModel = TableRegistry::get('Payments');

        if (isset($this->requestData['apikey'])) {
            $this->key = $this->requestData['apikey'];
        } else {
            return;
        }

        //Obtener ApiKey
        //Fallback (Si no existe apikey en el request, setea el tag de unidentified)
        if (!$this->key) {
            $this->invalid_request = false;
        } else {
            //Obtenemos la configuración del usuario y la instancia del Api Key
            $this->ApiInstance = $this->ApiModel->find('all', [
                'conditions' => ['key_api' => $this->key]
            ])->first();

            //(Configuracion del usuario)
            $this->Config = $this->ConfigModel->find('all', [
                'conditions' => ['user_id' => $this->ApiInstance->user_id]
            ])->first();


            if ($this->Config != NULL && $this->ApiInstance != NULL) {
                //URL configurada por el usuario de su WordPress
                $wp_url = $this->Config->url;

                //Links del API de WordPress
                $this->WPLinks = [
                    'main' => $wp_url,
                    'auth' => $wp_url . "/wp-json/jwt-auth/v1/token",
                    'products.get' => $wp_url . "/wp-json/wc/v2/products"
                ];

                $this->WooData = [
                    'consumer_key' => $this->Config->consumer_key,
                    'consumer_secret' => $this->Config->consumer_secret
                ];

                $this->PaymentData = [
                        'paypal' => [
                            'ClientID' => $this->Config->paypal_client_id,
                            'ClientSecret' => $this->Config->paypal_secret,
                            'ReceiverEmail' => $this->Config->paypal_email
                        ]
                    ];

                $this->WooClient = new WooClient(
                    $this->WPLinks['main'], 
                    $this->WooData['consumer_key'], 
                    $this->WooData['consumer_secret'],
                    [
                        'wp_api' => true,
                        'version' => 'wc/v2',
                    ]
                );

                $this->PayPalContext = new \PayPal\Rest\ApiContext(
                        new \PayPal\Auth\OAuthTokenCredential(
                            $this->PaymentData['paypal']['ClientID'],     // ClientID
                            $this->PaymentData['paypal']['ClientSecret']      // ClientSecret
                        )
                );


                $this->WooConfig = [
                    'appname' => $this->Config->appname,
                    'paypal_client_id' => $this->PaymentData['paypal']['ClientID']
                ];
                
            } else {
                $this->invalid_request = false;
            } 

        }
        
    }

    public function getCustomer($id) {
        $customer = $this->WooClient->get("customers/$id");
        return $customer;
    }
    
    public function updateCustomer() {
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        //Verificacion de campos
        if (!$this->requestData('username') || !$this->requestData('password') && !$this->requestData('customer_data')) return false;
    
        $user = $this->identify();
        $data = $this->requestData('customer_data');
        if ($user->json['token']) {
            $r = $this->WooClient->put("customers/".$user->customer->id, $data);
            return $r;
        } else {
            return false;
        }
    }

    public function identify() {
        
        //Si el usuario no mandó API key, retorna falso.
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        //Verificacion de campos
        if (!$this->requestData('username') || !$this->requestData('password')) return false;

        //Se hace la llamada al WordPress del usuario para obtener el user token.
        $response = $this->http->post($this->WPLinks['auth'], [
            'username' => $this->requestData("username"),
            'password' => $this->requestData("password")
        ], [
            'timeout' => 120
        ]);

        $customer = $this->CustomersModel->find('all', [
            'conditions' => ['username' => $this->requestData('username')]
        ])->first();

 
        $response->customer = $this->getCustomer($customer->customer);
        
        return $response;
        

    }

    public function getProducts() {
        

        if (property_exists($this, "invalid_request")) {
            return false;
        }

        if (!$this->requestData('apikey')) return false;


        $response = $this->WooClient->get("products");

        

        return $response;
    }

    public function getProduct($id) {
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        if (!$this->requestData('apikey')) return false;

        $response = $this->WooClient->get("products/$id");

        return $response;
    }

    public function sendOrder($order) {
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        if (!$this->requestData('apikey')) return false;

        $response = $this->WooClient->post('orders', $order);

        return $response;
    }

    public function getOrder($id) {
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        if (!$this->requestData('apikey')) return false;

        $response = $this->WooClient->get("orders/$id");

        return $response;
    }

    public function getCategories() {
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        if (!$this->requestData('apikey')) return false;

        $response = $this->WooClient->post('products/categories');

        return $response;
    }

    public function register() {
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        if (!$this->requestData('apikey') && !$this->requestData('customer_data')) return false;

        $response = $this->WooClient->post('customers', $this->requestData('customer_data'));

        $customer = $this->CustomersModel->newEntity();

        $customer->username = $response->username;

        $customer->customer = $response->id;

        $customer = $this->CustomersModel->save($customer);

        return ['customer' => $customer, 'response' => $response];

    }

    public function getPaymentGateways() {
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        if (!$this->requestData('apikey')) return false;

        $response = $this->WooClient->get('payment_gateways');

        return $response;
    }

    public function appdata() {
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        if (!$this->requestData('apikey')) return false;

        return $this->WooConfig;

    }




    /**
     * 
     * PAYMENTS
     * 
     */

    public function createPayment() {
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        if (!$this->requestData('apikey') || !$this->requestData('order_id')) return false;


    }


    public function verifyPaypalPayment() {
        if (property_exists($this, "invalid_request")) {
            return false;
        }

        if (!$this->requestData('apikey') || !$this->requestData('paypal_email') || !$this->requestData('order_id') || $this->requestData('total')) return false;

        $order = $this->getOrder($this->requestData('order_id'));

        if ($order) {
            $payment = $this->PaymentsModel->find('all', [
                'conditions' => [
                    'payer_email' => $this->requestData('paypal_email'),
                    'total' => $this->requestData('total'),
                    'receiver_email' => $this->PaymentData['paypal']['ReceiverEmail']
                ]
            ])->first();

            if ($payment) {
                $total = $payment->total;
                $this->PaymentsModel->delete($payment);
                return $total;
            } else {
                return false;
            }
        }

    }

}
