<?php namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class UsersController extends AppController
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

        $this->Auth->allow();
    }

    /**
     * Callback richiamata in automatico che stabilisce se l'utente loggato ha i permessi per accedere alle action del controller
     *
     * @param array $user Dati dell'utente loggato
     * @return boolean Utente autorizzato?
     */
    public function isAuthorized($user = null)
    {
        return true;
    }

//    public function implementedEvents()
//    {
//        return parent::implementedEvents() + [
//            'Auth.afterIdentify' => 'afterIdentify',
//            // 'Auth.logout' => 'logout'
//        ];
//    }

    public function identify($token)
    {
        $this->Auth->setUser(['token' => $token]);
        return $this->redirect($this->Auth->redirectUrl());
    }

//    /**
//     * Auth.afterIdentify callback
//     *
//     * @param Event $event
//     * @param array $user
//     */
//    public function afterIdentify(Event $event, array $user)
//    {
//        $user['account'] = TableRegistry::get('Accounts')->find()
//            ->where(['Accounts.id' => $user['account_id']])
//            ->first()
//            ->toArray();
//
//        return $user;
//    }

    /**
     * Pagina di logout
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Controlla il ruolo dell'utente loggato e restituisce i dati della pagina da visualizzare dopo il login.
     * Viene inoltre effettuato un controllo sul parametro 'r' (redirect) per personalizzare eventualmente la pagina di atterraggio.
     *
     * @return array|boolean Dati della pagina di redirect
     */
    protected function _redirectAfterLogin($user)
    {
        return $this->Auth->redirectUrl();
    }
}
