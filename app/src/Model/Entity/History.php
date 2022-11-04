<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * History Entity
 *
 * @property int $id
 * @property int $player_id
 * @property int $clan_id
 * @property \Cake\I18n\FrozenTime $joined
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Clan $clan
 */
class History extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'player_id' => true,
        'clan_id' => true,
        'joined' => true,
        'user' => true,
        'clan' => true,
    ];
}
