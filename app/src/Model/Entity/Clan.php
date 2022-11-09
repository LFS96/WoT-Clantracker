<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Clan Entity
 *
 * @property int $id
 * @property string $tag
 * @property string $name
 * @property string|null $description
 * @property string|null $lang_id
 *
 * @property \App\Model\Entity\History[] $history
 * @property \App\Model\Entity\Lang[] $langs
 * @property \App\Model\Entity\Player[] $players
 */
class Clan extends Entity
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
        'tag' => true,
        'name' => true,
        'description' => true,
        'lang_id' => true,
        'history' => true,
        'users' => true,
        'langs' => true,
    ];
}
