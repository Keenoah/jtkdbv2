<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class Admin extends Entity
{
    // 1. Accessibility
    // IMPORTANT: Note the word 'array' before $_accessible
    protected array $_accessible = [
        'username' => true,
        'password' => true,
        'created' => true,
        'modified' => true,
    ];

    // 2. Hidden fields
    // IMPORTANT: Note the word 'array' before $_hidden. 
    protected array $_hidden = [
        'password',
    ];

    // Password hashing method
    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }
}