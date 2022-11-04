<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Players Model
 *
 * @property \App\Model\Table\ClansTable&\Cake\ORM\Association\BelongsTo $Clans
 * @property \App\Model\Table\HistoriesTable&\Cake\ORM\Association\HasMany $Histories
 *
 * @method \App\Model\Entity\Player newEmptyEntity()
 * @method \App\Model\Entity\Player newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Player[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Player get($primaryKey, $options = [])
 * @method \App\Model\Entity\Player findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Player patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Player[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Player|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Player saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Player[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Player[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Player[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Player[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PlayersTable extends Table
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

        $this->setTable('players');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clans', [
            'foreignKey' => 'clan_id',
        ]);
        $this->hasMany('Histories', [
            'foreignKey' => 'player_id',
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
            ->scalar('nickname')
            ->maxLength('nickname', 255)
            ->requirePresence('nickname', 'create')
            ->notEmptyString('nickname');

        $validator
            ->integer('clan_id')
            ->allowEmptyString('clan_id');

        $validator
            ->dateTime('quit')
            ->allowEmptyDateTime('quit');

        $validator
            ->dateTime('lastBattle')
            ->allowEmptyDateTime('lastBattle');

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
        $rules->add($rules->existsIn('clan_id', 'Clans'), ['errorField' => 'clan_id']);

        return $rules;
    }
}
