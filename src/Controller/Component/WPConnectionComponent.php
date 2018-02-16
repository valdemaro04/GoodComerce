<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

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



        if ($this->requestData['apikey']) {
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


            if (property_exists($this, "Config")) {
                //URL configurada por el usuario de su WordPress
                $wp_url = $this->Config->url;

                //Links del API de WordPress
                $this->WPLinks = [
                    'main' => $wp_url,
                    'auth' => $wp_url . "/jwt-auth/v1/token"
                ];
            } else {
                $this->invalid_request = false;
            }

            
            

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

        debug($response);
        


        
    }
}
