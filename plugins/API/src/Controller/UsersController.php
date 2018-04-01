<?php namespace API\Controller;

use API\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 */
class UsersController extends AppController
{

    /**
     * Initialize method
     */
    public function initialize()
    {
        parent::initialize();

        $this->Security->config('unlockedActions', ['add']);

        if (in_array($this->request->action, ['add'])) {
            $this->eventManager()->off($this->Csrf);
        }
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow();
    }

    public function add()
    {
        $this->loadModel('API.Users');
        // Creo un'entità vuota
        $user = $this->Users->newEntity();

        if ($this->request->is(['post', 'put'])) {
            //patchEntity con la validazione per Agent
            $patchedUser = $this->Users->patchEntity($user, $this->request->data(), [
                'validate' => 'signup'
            ]);

            $savedUser = $this->Users->save($patchedUser);

            if ($savedUser) {
                $message = __('Iscrizione completata con successo');
                $type = 'success';
            } else {
                $message = __("Completare correttamente il modulo \n") . $this->__getErrors($patchedUser);
                $type = 'error';
            }

            return $this->response->withType('json')
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'message' => $message,
                        'type' => $type,
            ]));
        }

        throw new NotFoundException;
    }

    public function login()
    {
        $this->loadModel('API.Users');
       
        if ($this->request->is(['post', 'put'])) {

            $user = $this->Users->find()
                ->where([
                    'Users.username' => $this->request->getData('username'),
                ])
                ->first();

            if ($user && (new DefaultPasswordHasher)->check($this->request->getData('password'), $user->password)) {
                $token = Text::uuid();
                $this->Users->updateAll(['token' => $token], ['id' => $user->id]);
                $message = __("Ok");
                $auth = true;
            } else {
                $message = __("Credenziali non valide");
                $token = null;
                $auth = false;
            }

            return $this->response->withType('json')
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'message' => $message,
                        'auth' => $auth,
                        'token' => $token,
            ]));
        }
    }

    private function __getErrors($entity)
    {
        $text = [];
        if ($entity->getErrors()) {

            foreach ($entity->getErrors() as $errors) {
                if (is_array($errors)) {
                    foreach ($errors as $error) {
                        $text[] = "- " . $error;
                    }
                } else {
                    $text[] = "- " . $errors;
                }
            }
        }
        return implode("\n \r", $text);
    }
}
