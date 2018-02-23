<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Config Entity
 *
 * @property int $id
 * @property string $url
 * @property string $consumer_key
 * @property string $consumer_secret
 * @property string $appname
 * @property string $paypal_client_id
 * @property string $paypal_secret
 * @property string $paypal_email
 * @property int $user_id
 *
 * @property \App\Model\Entity\PaypalClient $paypal_client
 * @property \App\Model\Entity\User $user
 */
class Config extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'url' => true,
        'consumer_key' => true,
        'consumer_secret' => true,
        'appname' => true,
        'paypal_client_id' => true,
        'paypal_secret' => true,
        'paypal_email' => true,
        'user_id' => true,
        'paypal_client' => true,
        'user' => true
    ];
}
