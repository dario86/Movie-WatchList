<?php namespace API\Controller;

use API\Controller\AppController;
use Cake\Http\Client;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\Event\Event;

/**
 * Movies Controller
 *
 * @method \API\Model\Entity\Movie[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MoviesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('API.Users');
        $this->loadModel('API.MoviesUsers');

        if (in_array($this->request->action, ['add', 'delete', 'setWatched'])) {
            $this->eventManager()->off($this->Csrf);
        }
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
        $this->Security->config('unlockedActions', ['add', 'delete', 'setWatched']);
    }

    /**
     * Add MoviesUsers and, if not exists, new Movie
     *
     * @throws NotFoundException
     */
    public function add()
    {
        if ($this->request->is(['ajax'])) {
            $user = $this->Users->find()
                ->where(['Users.token' => $this->request->header('Authorization')])
                ->first();

            if (!$user || empty($this->request->header('Authorization'))) {
                throw new NotFoundException;
            }

            // Call to api moviedb to check if title exists and to get external_id
            $http = new Client();
            $response = $http->get('https://api.themoviedb.org/3/search/movie', [
                'api_key' => Configure::read('themoviedb_api_key'),
                'language' => 'it-IT',
                'query' => $this->request->getData('title')
            ]);

            // Take first results
            if (!empty($response->json['results'][0])) {
                $result = $response->json['results'][0];

                // Check if movie exists in local database
                $movie = $this->Movies->find()
                    ->where(['external_id' => $result['id']])
                    ->first();

                // Movie exists in local database
                if ($movie) {
                    $output = $this->MoviesUsers->customSave($movie->id, $user->id, $this->request->getData('watched'));
                }


                // New Movie
                else {
                    $output = $this->Movies->customSave($this->request->getData('title'), $result['id'], $user->id, $this->request->getData('watched'));
                }
            }

            // No Movie found in external API
            else {
                $output = [
                    'type' => 'error',
                    'message' => __('Nessun film trovato'),
                ];
            }

            return $this->response->withType('json')
                    ->withType('application/json')
                    ->withStringBody(json_encode($output));
        }
        throw new NotFoundException;
    }

    /**
     * Search user Movies. Called custom find method `movies`
     *
     * @return type
     */
    public function search()
    {
        $movies = $this->Movies->find('movies', [
            'user_token' => $this->request->header('Authorization'),
            'data' => $this->request->getData()
        ]);

        return $this->response->withType('json')
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'data' => $movies->all(),
        ]));
    }

    /**
     * Delete association MoviesUsers
     */
    public function delete()
    {
        if ($this->request->is(['post', 'put']) &&
            !empty($this->request->getData('id'))) {

            $user = $this->Users->find()
                ->where(['Users.token' => $this->request->header('Authorization')])
                ->first();

            if (!$user || empty($this->request->header('Authorization'))) {
                throw new NotFoundException;
            }

            // Check if id belongs to logged user
            $mu = $this->MoviesUsers->find()
                ->where([
                    'MoviesUsers.id' => $this->request->getData('id'),
                    'MoviesUsers.user_id' => $user->id])
                ->first();
            
            if ($mu) {
                $delete = $this->MoviesUsers->delete($mu);

                $this->response->body($delete);
                return $this->response;
            }
        }
        
        $this->response->body(-1);
        return $this->response;
    }

    /**
     * Change watched field
     *
     * @throws NotFoundException
     */
    public function setWatched()
    {
        if ($this->request->is(['post', 'put']) && !empty($this->request->getData('id'))) {
            $user = $this->Users->find()
                ->where(['Users.token' => $this->request->header('Authorization')])
                ->first();

            if (!$user || empty($this->request->header('Authorization'))) {
                throw new NotFoundException;
            }

            // Check if id belongs to logged user
            $mu = $this->MoviesUsers->find()
                ->select(['MoviesUsers.id'])
                ->where([
                    'MoviesUsers.id' => $this->request->getData('id'),
                    'MoviesUsers.user_id' => $user->id])
                ->first();

            if ($mu) {
                $this->MoviesUsers->updateAll(['watched' => $this->request->getData('watched')], ['id' => $mu->id]);
                $this->response->body($this->request->data['id']);
                return $this->response;
            }
        }
        $this->response->body(-1);
        return $this->response;
    }
}
