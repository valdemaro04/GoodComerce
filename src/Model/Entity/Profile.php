<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Profile Entity
 *
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $country
 * @property string $city
 * @property string $state
 * @property string $email
 * @property int $number_phone
 * @property int $user_id
 *
 * @property \App\Model\Entity\User $user
 */
class Profile extends Entity
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
        'name' => true,
        'last_name' => true,
        'country' => true,
        'city' => true,
        'state' => true,
        'email' => true,
        'number_phone' => true,
        'user_id' => true,
        'user' => true
    ];
}
