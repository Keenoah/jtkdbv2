<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Complaint Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $officer_id
 * @property int|null $admin_id
 * @property string|null $category
 * @property string|null $complaint_text
 * @property string|null $status
 * @property string|null $file_path
 * @property string|null $employer_name
 * @property string|null $employer_address
 * @property string|null $employer_tel
 * @property string|null $employer_email
 * @property string|null $person_in_charge
 * @property string|null $comp_name_1
 * @property string|null $comp_ic_1
 * @property string|null $comp_name_2
 * @property string|null $comp_ic_2
 * @property string|null $comp_name_3
 * @property string|null $comp_ic_3
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Officer $officer
 * @property \App\Model\Entity\Admin $admin
 */
class Complaint extends Entity
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
    protected array $_accessible = [
        'user_id' => true,
        'officer_id' => true,
        'admin_id' => true,
        'category' => true,
        'complaint_text' => true,
        'status' => true,
        'file_path' => true,
        'employer_name' => true,
        'employer_address' => true,
        'employer_tel' => true,
        'employer_email' => true,
        'person_in_charge' => true,
        'comp_name_1' => true,
        'comp_ic_1' => true,
        'comp_name_2' => true,
        'comp_ic_2' => true,
        'comp_name_3' => true,
        'comp_ic_3' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'officer' => true,
        'admin' => true,
    ];
}
