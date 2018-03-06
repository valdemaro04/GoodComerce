<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use App\Utility\PaypalIPN;
/**
 * Api Controller
 *
 *
 * @method \App\Model\Entity\Api[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApiController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        
    }

    public function authorize() {
        
        $message = "";
        
        if ($this->request->is('post')) {
            if ($result = $this->WPConnection->identify()) {
                $message = "Identificado.";
            } else {
                $message = "No identificado";
            }
            
            $this->set([
                'message' => $message,
                'type' => 'single',
                'data' => [
                    'user_token' => $result->json['token'],
                    'user_data' => [
                        'email' => $result->json['user_email'],
                        'username' => $result->json['user_nicename']
                    ],
                    'customer' => $result->customer
                ],
                'fields' => [
                    [
                        'name' => 'user_token',
                        'type' => 'String'
                    ],
                    [
                        'name' => 'user_data',
                        'type' => 'Object',
                        'fields' => [
                            [
                                'name' => 'email',
                                'type' => 'String'
                            ],
                            [
                                'name' => 'username',
                                'type' => 'String'
                            ]
                        ]
                    ]
                ],
                '_serialize' => ['message', 'data', 'type', 'fields']
            ]);
        } else {
            $this->set([
                'message' => "Method not supported",
                '_serialize' => ['message']
            ]);
        }
        
        
    }

    public function products() {
        if ($this->request->is('post')) {
            $products = $this->WPConnection->getProducts();
            if ($products) {
                $this->set([
                    'products' => $products,
                    '_serialize' => ['products']
                ]);
            } else {
                $this->set([
                    'result' => $products,
                    '_serialize' => ['result']
                ]);
            }
        } else {
            $this->set([
                'message' => "Method not supported",
                '_serialize' => ['message']
            ]);
        }
    }

    public function sendorder() {
        if ($this->request->is('post')) {
            


            $data = $this->request->getData();


            $customer = $data['customer'];
            $cart = $data['cart'];


            if (array_key_exists('customer_id', $data['customer'])) {
                $order = [
                    'payment_method' => $this->data['payment_method'],
                    'set_paid' => false,
                    'customer_id' => $data['customer']['customer_id'],
                    'billing' => $data['customer']['billing'],
                    'shipping' => $data['customer']['shipping'],
                    'line_items' => $cart
                ];
            } else {
                $order = [
                    'payment_method' => $this->data['payment_method'],
                    'set_paid' => false,
                    'billing' => $data['customer']['billing'],
                    'shipping' => $data['customer']['shipping'],
                    'line_items' => $cart
                ];
            }
            

            $orderSend = $this->WPConnection->sendOrder($order);

            if ($orderSend) {
                $this->set([
                    'result' => $orderSend,
                    '_serialize' => ['result']
                ]);
            } else {
                $this->set([
                    'result' => false,
                    '_serialize' => ['result']
                ]);
            }
            
        }
    }

    function filterGateways($gateway) {
        return $gateway->enabled;
    }

    public function paymentgateways() {
        if ($this->request->is('post')) {
            $gateways = $this->WPConnection->getPaymentGateways();
            $gateways = array_filter($gateways, [$this, 'filterGateways']);
            $this->set([
                'gateways' => $gateways,
                '_serialize' => ['gateways']
            ]);
        }
    }

    public function register() {
        if ($this->request->is('post')) {
            $data = $this->WPConnection->register();
            /*if (!$data) {
                $this->set([
                    'message' => 'invalid request',
                    'customer' => $data['customer'],
                    'response' => $data['response'],
                    '_serialize' => ['message', 'customer']
                ]);
            } else {
                $this->set([
                    'customer' => $customer,
                    '_serialize' => ['customer']
                ]);
            }*/

            $this->set([
                'message' => 'debug',
                'customer' => $data['customer'],
                '_serialize' => ['message', 'customer']
            ]);

            
        }
    }

    public function updatecustomer() {
        if($this->request->is('post')) {
            $r = $this->WPConnection->updateCustomer();
            $this->set([
                'result' => $r,
                '_serialize' => ['result']
            ]);
        }
    }

    public function appdata() {
        if ($this->request->is('post')) {
            $appdata = $this->WPConnection->appdata();
            $this->set([
                'config' => $appdata,
                '_serialize' => ['config']
            ]);
        }
    }

    public function ipn() {
        $this->viewBuilder()->setLayout(false);
        $this->loadModel('Payments');
        if ($this->request->is('post')) {
            $ipn = new PaypalIPN();
            $verified = $ipn->verifyIPN();
            if ($verified) {
               $n = $this->Payments->newEntity();
               $n->payer_email = $verified['payer_email'];
               $n->receiver_email = $verified['receiver_email'];
               $n->total = $verified['mc_gross'];
               $n->currency = $verified['mc_currency'];
               $n->verified = 0;
               if ($n->currency) {
                if ($this->Payments->save($n)) {
                    $this->set([
                        'ipn' => $verified,
                        '_serialize' => ['ipn']
                        ]);
                   } else {
                       $this->set([
                           'ipn' => "NOT_VERIFIED_CORRECTLY",
                           '_serialize' => ['ipn']
                       ]);
                   }
               } else {
                   $this->set([
                        'ipn' => "NO_CURRENCY",
                        "debug" => $this->WPConnection->appdata(),
                        '_serialize' => ['ipn', 'debug']
                   ]);
               }
               
               
               
               
            } else {
                $this->set([
                    'ipn' => "SPOOFED_IPN;URE_NOT_IPN",
                    '_serialize' => ['ipn']
                    ]);
            }

            
        } else {
            $this->set([
                'ipn' => "URE_NOT_IPN",
                '_serialize' => ['ipn']
            ]);
        }
    }

    public function verifypaypal() {
        if ($this->request->is('post')) {
            $k = $this->WPConnection->verifyPaypalPayment();
            $this->set([
                'result' => $k,
                '_serialize' => ['result']
            ]);
        } else {
            $this->set([
                'result' => 'Method not supported',
                '_serialize' => ['result']
            ]);
        }
    }

    public function stripepayment() {
        if ($this->request->is('post')) {
            if ($k = $this->WPConnection->processStripePayment()) {
                if ($k) {
                    $this->set([
                        'result' => $k,
                        "_serialize" => 'result'
                    ]);
                } else {
                    $this->set([
                        'result' => $k,
                        "_serialize" => 'result'
                    ]);
                }
            } else {
                $this->set([
                    'result' => $k,
                    "_serialize" => 'result'
                ]);
            }
        }
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['stripepayment','verifypaypal', 'ipn','authorize', 'products', 'sendorder', 'paymentgateways', 'register', 'updatecustomer', 'appdata']);
    }


}
