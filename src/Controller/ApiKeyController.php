<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ApiKey Controller
 *
 * @property \App\Model\Table\ApiKeyTable $ApiKey
 *
 * @method \App\Model\Entity\ApiKey[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApiKeyController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $apiKey = $this->paginate($this->ApiKey);

        $this->set(compact('apiKey'));
    }

    /**
     * View method
     *
     * @param string|null $id Api Key id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $apiKey = $this->ApiKey->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('apiKey', $apiKey);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $apiKey = $this->ApiKey->newEntity();
        if ($this->request->is('post')) {
            $apiKey = $this->ApiKey->patchEntity($apiKey, $this->request->getData());
            if ($this->ApiKey->save($apiKey)) {
                $this->Flash->success(__('The api key has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The api key could not be saved. Please, try again.'));
        }
        $users = $this->ApiKey->Users->find('list', ['limit' => 200]);
        $this->set(compact('apiKey', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Api Key id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $apiKey = $this->ApiKey->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $apiKey = $this->ApiKey->patchEntity($apiKey, $this->request->getData());
            if ($this->ApiKey->save($apiKey)) {
                $this->Flash->success(__('The api key has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The api key could not be saved. Please, try again.'));
        }
        $users = $this->ApiKey->Users->find('list', ['limit' => 200]);
        $this->set(compact('apiKey', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Api Key id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $apiKey = $this->ApiKey->get($id);
        if ($this->ApiKey->delete($apiKey)) {
            $this->Flash->success(__('The api key has been deleted.'));
        } else {
            $this->Flash->error(__('The api key could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
