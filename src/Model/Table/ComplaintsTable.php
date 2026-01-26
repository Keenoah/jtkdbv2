<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Complaints Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\OfficersTable&\Cake\ORM\Association\BelongsTo $Officers
 * @property \App\Model\Table\AdminsTable&\Cake\ORM\Association\BelongsTo $Admins
 *
 * @method \App\Model\Entity\Complaint newEmptyEntity()
 * @method \App\Model\Entity\Complaint newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Complaint> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Complaint get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Complaint findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Complaint patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Complaint> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Complaint|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Complaint saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Complaint>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Complaint>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Complaint>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Complaint> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Complaint>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Complaint>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Complaint>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Complaint> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ComplaintsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('complaints');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // 1. The Public User (Owner of the complaint)
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);

        // 2. The Officer (Assigned to investigate)
        $this->belongsTo('Officers', [
            'foreignKey' => 'officer_id',
            'joinType' => 'LEFT', 
        ]);

        // 3. The Admin (Who processed/updated the case)
        $this->belongsTo('Admins', [
            'foreignKey' => 'admin_id',
            'joinType' => 'LEFT',
        ]);
        
        // (Duplicate block removed from here)
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
public function validationDefault(\Cake\Validation\Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id', null, 'create');

        // --- REQUIRED FIELDS (Mandatory) ---
        $validator
            ->scalar('category')
            ->maxLength('category', 50)
            ->requirePresence('category', 'create')
            ->notEmptyString('category', 'Please select a category.');

        $validator
            ->scalar('complaint_text')
            ->requirePresence('complaint_text', 'create')
            ->notEmptyString('complaint_text', 'Please describe the incident.');

        $validator
            ->scalar('employer_name')
            ->maxLength('employer_name', 255)
            ->requirePresence('employer_name', 'create')
            ->notEmptyString('employer_name', 'Employer name is required.');

        // UPDATED: Now Required
        $validator
            ->scalar('person_in_charge')
            ->maxLength('person_in_charge', 255)
            ->requirePresence('person_in_charge', 'create')
            ->notEmptyString('person_in_charge', 'Person in charge is required.');

        $validator
            ->scalar('employer_address')
            ->requirePresence('employer_address', 'create')
            ->notEmptyString('employer_address', 'Employer address is required.');
            
        $validator
            ->scalar('employer_tel')
            ->maxLength('employer_tel', 20)
            ->requirePresence('employer_tel', 'create')
            ->notEmptyString('employer_tel', 'Employer phone is required.');

        // UPDATED: Now Required
        $validator
            ->email('employer_email') // Checks for valid email format
            ->requirePresence('employer_email', 'create')
            ->notEmptyString('employer_email', 'Employer email is required.');

        // --- OPTIONAL FIELDS ---
        $validator
            ->allowEmptyFile('file_path')
            ->allowEmptyString('comp_name_1')
            ->allowEmptyString('comp_ic_1')
            ->allowEmptyString('comp_name_2')
            ->allowEmptyString('comp_ic_2')
            ->allowEmptyString('comp_name_3')
            ->allowEmptyString('comp_ic_3');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['officer_id'], 'Officers'), ['errorField' => 'officer_id']);
        $rules->add($rules->existsIn(['admin_id'], 'Admins'), ['errorField' => 'admin_id']);

        return $rules;
    }
}
