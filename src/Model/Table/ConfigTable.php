<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Config Model
 *
 * @property \App\Model\Table\PaypalClientsTable|\Cake\ORM\Association\BelongsTo $PaypalClients
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Config get($primaryKey, $options = [])
 * @method \App\Model\Entity\Config newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Config[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Config|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Config patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Config[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Config findOrCreate($search, callable $callback = null, $options = [])
 */
class ConfigTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('config');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PaypalClients', [
            'foreignKey' => 'paypal_client_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmpty('url');

        $validator
            ->scalar('consumer_key')
            ->requirePresence('consumer_key', 'create')
            ->notEmpty('consumer_key');

        $validator
            ->scalar('consumer_secret')
            ->requirePresence('consumer_secret', 'create')
            ->notEmpty('consumer_secret');

        $validator
            ->scalar('appname')
            ->requirePresence('appname', 'create')
            ->notEmpty('appname');

        $validator
            ->scalar('currency')
            ->requirePresence('currency', 'create')
            ->notEmpty('currency');

        $validator
            ->scalar('paypal_secret')
            ->requirePresence('paypal_secret', 'create')
            ->notEmpty('paypal_secret');

        $validator
            ->scalar('paypal_email')
            ->requirePresence('paypal_email', 'create')
            ->notEmpty('paypal_email');

        $validator
            ->scalar('stripe_secret_key')
            ->requirePresence('stripe_secret_key', 'create')
            ->notEmpty('stripe_secret_key');

        $validator
            ->scalar('stripe_public_key')
            ->requirePresence('stripe_public_key', 'create')
            ->notEmpty('stripe_public_key');

        $validator
            ->scalar('styling')
            ->requirePresence('styling', 'create')
            ->notEmpty('styling');

        $validator
            ->integer('paypal_enabled')
            ->requirePresence('paypal_enabled', 'create')
            ->notEmpty('paypal_enabled');

        $validator
            ->integer('stripe_enabled')
            ->requirePresence('stripe_enabled', 'create')
            ->notEmpty('stripe_enabled');

        $validator
            ->integer('registration_allowed')
            ->requirePresence('registration_allowed', 'create')
            ->notEmpty('registration_allowed');

        $validator
            ->integer('registration_needed')
            ->requirePresence('registration_needed', 'create')
            ->notEmpty('registration_needed');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['paypal_client_id'], 'PaypalClients'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
