<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

// FIX: The class name MUST be AdminsTable
class AdminsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // FIX: Point to the 'admins' table in your database
        $this->setTable('admins'); 
        
        $this->setDisplayField('username'); 
        $this->setPrimaryKey('id');

        // Automatically updates 'created' and 'modified' columns
        $this->addBehavior('Timestamp'); 
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        return $validator;
    }
}