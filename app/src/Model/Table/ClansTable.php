<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clans Model
 *
 * @property \App\Model\Table\PlayersTable&\Cake\ORM\Association\HasMany $Players
 * @property \App\Model\Table\LangsTable&\Cake\ORM\Association\BelongsToMany $Langs
 * @property \App\Model\Table\HistoriesTable&\Cake\ORM\Association\HasMany $Histories
 *
 * @method \App\Model\Entity\Clan newEmptyEntity()
 * @method \App\Model\Entity\Clan newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Clan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Clan get($primaryKey, $options = [])
 * @method \App\Model\Entity\Clan findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Clan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Clan[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Clan|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Clan saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Clan[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Clan[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Clan[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Clan[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ClansTable extends Table
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

        $this->setTable('clans');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Langs', [
            'foreignKey' => 'lang_id',
        ]);
        $this->hasMany('Histories', [
            'foreignKey' => 'clan_id',
        ]);
        $this->hasMany('Players', [
            'foreignKey' => 'clan_id',
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
            ->scalar('tag')
            ->maxLength('tag', 10)
            ->requirePresence('tag', 'create')
            ->notEmptyString('tag');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 4294967295)
            ->allowEmptyString('description');

        $validator
            ->scalar('lang_id')
            ->maxLength('lang_id', 3)
            ->allowEmptyString('lang_id');

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
        $rules->add($rules->existsIn('lang_id', 'Langs'), ['errorField' => 'lang_id']);

        return $rules;
    }
}
