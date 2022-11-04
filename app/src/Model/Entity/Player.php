<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Player Entity
 *
 * @property int $id
 * @property string $nickname
 * @property int|null $clan_id
 * @property \Cake\I18n\FrozenTime|null $quit
 * @property \Cake\I18n\FrozenTime|null $lastBattle
 *
 * @property \App\Model\Entity\Clan $clan
 * @property \App\Model\Entity\History[] $histories
 */
class Player extends Entity
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
        'nickname' => true,
        'clan_id' => true,
        'quit' => true,
        'lastBattle' => true,
        'clan' => true,
        'histories' => true,
    ];
}
