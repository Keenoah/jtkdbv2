<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Officers Model
 *
 * @property \App\Model\Table\ComplaintsTable&\Cake\ORM\Association\HasMany $Complaints
 *
 * @method \App\Model\Entity\Officer newEmptyEntity()
 * @method \App\Model\Entity\Officer newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Officer> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Officer get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Officer findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Officer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Officer> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Officer|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Officer saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Officer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Officer>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Officer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Officer> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Officer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Officer>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Officer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Officer> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OfficersTable extends Table
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

        $this->setTable('officers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Complaints', [
            'foreignKey' => 'officer_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('department')
            ->maxLength('department', 50)
            ->requirePresence('department', 'create')
            ->notEmptyString('department');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        return $validator;
    }
}
