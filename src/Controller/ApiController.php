<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

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
                    'result' => 'Not id',
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

            $orderSend = $this->WPConnection->sendOrder($data);

            $this->set([
                'result' => $orderSend,
                '_serialize' => ['result']
            ]);
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



    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);

        $this->Auth->allow(['authorize', 'products', 'sendorder', 'paymentgateways', 'register', 'updatecustomer', 'appdata']);
    }


}
