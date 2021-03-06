<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property string $payer_email
 * @property string $receiver_email
 * @property string $total
 * @property string $currency
 * @property int $verified
 */
class Payment extends Entity
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
        'payer_email' => true,
        'receiver_email' => true,
        'total' => true,
        'currency' => true,
        'verified' => true
    ];
}
