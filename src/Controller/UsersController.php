<?php
namespace App\Controller;
use Cake\Auth\DefaultPasswordHasher;
use App\Controller\AppController;
use Cake\Utility\Security;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users',));

    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Profile']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

   

    public function add()
    { //Cargando Modelo del perfil
        $this->loadModel('Profile');
        //Cargando Modelo de la api key
        $this->loadModel('Apikey');
        //Cargando Modelo de config
        $this->loadModel('Config');
        //Creando nueva inmstancia en ta tabla api_key
        $apikey = $this->Apikey->newEntity();
        //Creando nueva inmstancia en ta tabla profile
        $profile = $this->Profile->newEntity();
        //Creando nueva inmstancia en ta tabla  Users
        $user = $this->Users->newEntity();
        //Generando api_key
        $config = $this->Config->newEntity();
        //Generando config
        
        $hasher  = new DefaultPasswordHasher();
        $api_key_plain = Security::hash(Security::randomBytes(32), 'sha256', false);
        $key = $hasher->hash($api_key_plain);

        
        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, $this->request->getData());

            $profile = $this->Profile->patchEntity($profile, $this->request->getData()['profile']);
            
            $config = $this->Config->patchEntity($config, $this->request->getData()['config']);
            if ($newUser = $this->Users->save($user)) {
                
                $profile->user_id = $newUser->id;
                $profile->photo = "img/user.jpg";

                debug($profile); 
                $this->Profile->save($profile);
                $apikey->key_api = $key;
                $apikey->user_id = $newUser->id;
                
                $config->user_id = $newUser->id;
                
                $this->Apikey->save($apikey);

                $this->Config->save($config);
                $this->Flash->success(__('The user has been saved.'));

                //return $this->redirect(['action' => 'index']);
            }else{
               $this->Flash->error(__('The user could not be saved. Please, try again.')); 
            }
            
        }
        $this->set(compact('user', 'profile','config'));
    }
    public function confirmarCuenta($value='')
    {
        
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            debug($user);
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }
    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }
    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {   
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

        
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
