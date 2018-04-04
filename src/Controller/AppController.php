<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Controller\Component\AuthComponent;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Security');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('Csrf');
       
        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'Movies',
                'action' => 'home',
                'plugin' => null
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'login',
                'plugin' => null
            ],
        ]);
    }

    public function isAuthorized($user = null)
    {
        return true;
    }

    /**
     * BeforeRender hook for Controllers
     *
     * Called right before the view rendering phase starts
     *
     * @see http://book.cakephp.org/3.0/en/controllers/components.html#beforeRender
     * @param \Cake\Event\Event $event
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $this->response->disableCache();

        // Setting up theme
        $this->viewBuilder()->theme('AdminLTE');
        $this->viewBuilder()->layout('adminlte');
    }

    public function beforeRender(Event $event)
    {
        $this->viewBuilder()->setClassName('AdminLTE.AdminLTE');
    }
}
