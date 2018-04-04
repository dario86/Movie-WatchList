<?php namespace API\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MoviesUsers Model
 *
 * @property \API\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \API\Model\Table\MoviesTable|\Cake\ORM\Association\BelongsTo $Movies
 *
 * @method \API\Model\Entity\MoviesUser get($primaryKey, $options = [])
 * @method \API\Model\Entity\MoviesUser newEntity($data = null, array $options = [])
 * @method \API\Model\Entity\MoviesUser[] newEntities(array $data, array $options = [])
 * @method \API\Model\Entity\MoviesUser|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \API\Model\Entity\MoviesUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \API\Model\Entity\MoviesUser[] patchEntities($entities, array $data, array $options = [])
 * @method \API\Model\Entity\MoviesUser findOrCreate($search, callable $callback = null, $options = [])
 */
class MoviesUsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('movies_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'API.Users'
        ]);
        $this->belongsTo('Movies', [
            'foreignKey' => 'movie_id',
            'className' => 'API.Movies'
        ]);

        $this->addBehavior('Timestamp');

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->boolean('watched')
            ->requirePresence('watched', 'create')
            ->notEmpty('watched');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['movie_id'], 'Movies'));
        $rules->add($rules->isUnique(['user_id', 'movie_id']));
        
        return $rules;
    }
}
