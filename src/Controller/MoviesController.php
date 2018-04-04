<?php namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Movies Controller
 *
 *
 * @method \App\Model\Entity\Movie[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MoviesController extends AppController
{

    /**
     * Initialize method
     */
    public function initialize()
    {
        parent::initialize();
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['home']);
    }

    /**
     * home method
     */
    public function home()
    {
        if (empty($this->Auth->user())) {
            return $this->redirect(['controller' => 'Pages', 'action' => 'signup']);
        }
    }

    /**
     * show method
     */
    public function show()
    {
        
    }

    /**
     * Add method
     */
    public function add()
    {
        
    }
}
