<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Student Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property int $school_class_id
 * @property string $language_group
 *
 * @property \App\Model\Entity\SchoolClass $school_class
 */
class Student extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'gender' => true,
        'school_class_id' => true,
        'language_group' => true,
        'school_class' => true,
    ];
}
