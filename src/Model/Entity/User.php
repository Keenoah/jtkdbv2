<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher; // Added for security
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $ic_number
 * @property string|null $gender
 * @property int|null $age
 * @property string|null $nationality
 * @property string|null $address
 * @property string|null $email
 * @property string|null $phone
 * @property string $password
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Complaint[] $complaints
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'ic_number' => true,
        'gender' => true,
        'age' => true,
        'nationality' => true,
        'address' => true,
        'email' => true,
        'phone' => true,
        'password' => true,
        'created' => true,
        'modified' => true,
        'complaints' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * Hash password before saving to database.
     * * This fulfills the requirement for secure authentication.
     *
     * @param string $password Password to hash
     * @return string|null
     */
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return $password;
    }
}