<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lang Entity
 *
 * @property string $id
 * @property string|null $iso2
 * @property string|null $name
 *
 * @property \App\Model\Entity\Clan[] $clans
 */
class Lang extends Entity
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
        'iso2' => true,
        'name' => true,
        'clans' => true,
    ];
}
