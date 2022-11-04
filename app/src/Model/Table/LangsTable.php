<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Langs Model
 *
 * @property \App\Model\Table\ClansTable&\Cake\ORM\Association\HasMany $Clans
 *
 * @method \App\Model\Entity\Lang newEmptyEntity()
 * @method \App\Model\Entity\Lang newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Lang[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lang get($primaryKey, $options = [])
 * @method \App\Model\Entity\Lang findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Lang patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Lang[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lang|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lang saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lang[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lang[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lang[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lang[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class LangsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('langs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Clans', [
            'foreignKey' => 'lang_id',
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
            ->scalar('iso2')
            ->maxLength('iso2', 2)
            ->allowEmptyString('iso2');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        return $validator;
    }
}
