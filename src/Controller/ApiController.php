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
        
        
        if ($this->WPConnection->identify()) {
            $message = "Identificado.";
        } else {
            $message = "No identificado";
        }

        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }


    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);

        $this->Auth->allow(['authorize']);
    }


}
