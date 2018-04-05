<?php namespace API\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;
use Cake\Utility\Security;
use Cake\Utility\Text;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Model
 *
 * @property \App\Model\Table\AccountsTable|\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\ActivitiesTable|\Cake\ORM\Association\HasMany $Activities
 * @property \App\Model\Table\ApplicationsTable|\Cake\ORM\Association\HasMany $Applications
 * @property \App\Model\Table\NotesTable|\Cake\ORM\Association\HasMany $Notes
 * @property \App\Model\Table\PipelinesTable|\Cake\ORM\Association\HasMany $Pipelines
 * @property \App\Model\Table\ProfileExperiencesTable|\Cake\ORM\Association\HasMany $ProfileExperiences
 * @property \App\Model\Table\ProfilesTable|\Cake\ORM\Association\HasMany $Profiles
 * @property \App\Model\Table\StagesTable|\Cake\ORM\Association\HasMany $Stages
 * @property \App\Model\Table\ProjectsTable|\Cake\ORM\Association\HasMany $Projects
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
            'className' => 'API.Roles'
        ]);

        $this->belongsToMany('Movies', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'Movie_id',
            'joinTable' => 'movies_users',
            'className' => 'API.Movies',
            'propertyName' => 'movies_users',
            'through' => 'API.MoviesUsers',
        ]);
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
            ->scalar('username')
            ->maxLength('username', 127)
            ->allowEmpty('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 127)
            ->allowEmpty('password');

        $validator
            ->scalar('name')
            ->maxLength('name', 127)
            ->allowEmpty('name');

        $validator
            ->scalar('surname')
            ->maxLength('surname', 127)
            ->allowEmpty('surname');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 127)
            ->allowEmpty('ip');

        $validator
            ->scalar('code')
            ->maxLength('code', 255)
            ->allowEmpty('code');

        return $validator;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationSignup(Validator $validator)
    {
        $validator
            ->notEmpty('username', __('Campo obbligatorio'))
            ->requirePresence('username', 'create')
            ->add('username', [
                'usernameFormat' => [
                    'rule' => 'email',
                    'message' => __('Email non valida')
                ],
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => __('Username già esistente')
                ],
            ])
            ->maxLength('username', 127)
            ->scalar('username')
            ->maxLength('username', 127)
            ->notEmpty('password', 'Campo obbligatorio')
            ->add('password', 'passwordLength', [
                'rule' => ['minLength', 4],
                'message' => __('Password non valida (minimo 4 caratteri)'),
            ])
            ->scalar('password')
            ->maxLength('password', 127)
            ->notEmpty('password_repeat', 'Campo obbligatorio')
            ->add('password_repeat', 'passwordRepeat', [
                'rule' => ['compareWith', 'password'],
                'message' => __('La password di verifica non coincide'),
            ])
            ->scalar('password_repeat')
            ->maxLength('password_repeat', 127)
            ->add('code', 'validCode', [
                'rule' => 'uuid',
                'message' => __('code non valido'),
            ])
            ->requirePresence('name', 'create')
            ->notEmpty('name', 'create')
            ->scalar('name')
            ->maxLength('name', 127)
            ->requirePresence('surname', 'create')
            ->notEmpty('surname', 'create')
            ->scalar('surname')
            ->maxLength('surname', 127);

        return $validator;
    }

    /**
     * @param \Cake\Event\Event $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        // Inserisco IP se è nuovo utente
        if ($entity->isNew()) {
            $entity->ip = env('REMOTE_ADDR');
            $entity->code = Security::hash(Text::uuid() . microtime(), 'sha1');
        }
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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
