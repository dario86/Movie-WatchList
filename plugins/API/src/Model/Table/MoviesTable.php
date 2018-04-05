<?php namespace API\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Movies Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Externals
 * @property \API\Model\Table\UsersTable|\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \API\Model\Entity\Movie get($primaryKey, $options = [])
 * @method \API\Model\Entity\Movie newEntity($data = null, array $options = [])
 * @method \API\Model\Entity\Movie[] newEntities(array $data, array $options = [])
 * @method \API\Model\Entity\Movie|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \API\Model\Entity\Movie patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \API\Model\Entity\Movie[] patchEntities($entities, array $data, array $options = [])
 * @method \API\Model\Entity\Movie findOrCreate($search, callable $callback = null, $options = [])
 */
class MoviesTable extends Table
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

        $this->setTable('movies');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Users', [
            'foreignKey' => 'movie_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'movies_users',
            'className' => 'API.Users',
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmpty('title');

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
        $rules->add($rules->isUnique(['external_id']));

        return $rules;
    }

    /**
     * Query from table Movies
     * .
     * Options:
     * -user_token: Users.token field
     * -data.watched MoviesUsers.watched field
     * -data.page query page
     * -data.limit total results to fetch
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findMovies(Query $query, array $options)
    {

        if (!empty($options['user_token'])) {
            $query->innerJoinWith('Users', function ($q) use ($options) {
                return $q->where(['Users.token' => $options['user_token']]);
            });
        }

        if (!empty($options['data']['watched'])) {
            $query->innerJoin(
                [
                'MU' => 'movies_users'
                ], [
                'MU.watched' => $options['data']['watched'] > 0 ? 1 : 0,
                'MU.movie_id = Movies.id'
            ]);
        }

        if (!empty($options['data']['page'])) {
            $query->page($options['data']['page']);
        }

        if (!empty($options['data']['limit'])) {
            $query->limit($options['data']['limit']);
        }

        return $query
                ->select([
                    'Movies.title', 'MoviesUsers.id', 'MoviesUsers.watched', 'MoviesUsers.created',
                    ]
                )->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                return $results->map(function ($row) {
                        $row['id'] = $row['_matchingData']['MoviesUsers']->id;
                        $row['created'] = $row['_matchingData']['MoviesUsers']->created->i18nFormat('dd-MM-yyyy HH:mm:ss');
                        $row['watched'] = $row['_matchingData']['MoviesUsers']->watched;
                        unset($row['_matchingData']);
                        return $row;
                    });
            });
    }

    public function store($movie, $user, $watched)
    {
        $mu = $this->find()
            ->where(['MoviesUsers.movie_id' => $movie->id,
                'MoviesUsers.user_id' => $user->id,
            ])
            ->first();

        if ($mu) {
            return [
                'type' => 'error',
                'message' => __('Film già presente nella tua lista')
            ];
        } else {
            $data['user_id'] = $user->id;
            $data['movie_id'] = $movie->id;
            $data['watched'] = $this->request->getData('watched');

            $movie = $this->MoviesUsers->patchEntity($movie, $data);

            $saved = $this->MoviesUsers->save($movie);

            if ($saved) {
                return [
                    'type' => 'success',
                    'message' => __('Film salvato')
                ];
            } else {
                return [
                    'type' => 'error',
                    'message' => __('Si è verificato un errore nel salvataggio')
                ];
            }
        }
    }

    /**
     *
     * @param type $externalId
     * @param type $user
     * @param type $watched
     */
    public function customSave($title, $externalId, $userId, $watched)
    {
        $movie = $this->newEntity([
            'title' => $title,
            'external_id' => $externalId,
            'movies_users' => [
                0 => [
                    'id' => $userId,
                    '_joinData' => [
                        'watched' => $watched
                    ]
                ]
            ]
        ]);

        $saved = $this->save($movie);

        if ($saved) {
            return [
                'type' => 'success',
                'message' => __('Film salvato')
            ];
        } else {
            return [
                'type' => 'error',
                'message' => __('Si è verificato un errore nel salvataggio')
            ];
        }
    }
}
