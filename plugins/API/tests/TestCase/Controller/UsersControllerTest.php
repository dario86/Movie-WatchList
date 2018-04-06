<?php namespace API\Test\TestCase\Controller;

use API\Controller\UsersController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * API\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.API.users',
        'plugin.API.roles',
        'plugin.API.movies_users',
        'plugin.API.movies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->configRequest([
            'environment' => [
                'REMOTE_ADDR' => '127.0.0.1',
            ]
        ]);

       // $this->now = Time::getTestNow();
       // $this->locale = Time::getDefaultLocale();

        $this->Users = TableRegistry::get('API.Users');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

//        Time::setTestNow($this->now);
//        Time::setDefaultLocale($this->locale);
//        Time::resetToStringFormat();

        \Cake\Cache\Cache::clear(false);
    }

    /**
     * Add new user
     *
     * @return void
     */
    public function testAddOk()
    {
        $countOld = $this->Users->find()->count();

        $data = [
            'name' => 'Dario',
            'surname' => 'Lap',
            'username' => 'example@example.it',
            'password' => 'dariop',
            'password_repeat' => 'dariop'
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/users/add', $data);

        // last user
        $user = $this->Users->find()
            ->orderDesc('id')
            ->first();

        $this->assertResponseOk();
        $this->assertEquals('success', json_decode($this->_getBodyAsString())->type);
        $this->assertEquals($countOld + 1, $this->Users->find()->count());
        $this->assertEquals('Dario', $user->name);
        $this->assertEquals('Lap', $user->surname);
        $this->assertEquals('example@example.it', $user->username);

        // Password will be encrypted
        $this->assertNotEquals('dariop', $user->password);

        $this->assertEmpty($user->token);
        $this->assertNotEmpty($user->code);
    }

    public function testAddWrongPasswordRepeat()
    {
        $countOld = $this->Users->find()->count();

        $data = [
            'name' => 'Dario',
            'surname' => 'Lap',
            'username' => 'example@example.it',
            'password' => 'dariop',
            'password_repeat' => 'dariopp'
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/users/add', $data);
        
        // last user
        $user = $this->Users->find()
            ->orderDesc('id')
            ->first();

        $this->assertResponseOk();
        $this->assertEquals('error', json_decode($this->_getBodyAsString())->type);
        $this->assertEquals($countOld, $this->Users->find()->count());
    }

    public function testAddWrongUsername()
    {
        $countOld = $this->Users->find()->count();

        $data = [
            'name' => 'Dario',
            'surname' => 'Lap',
            'username' => 'example',
            'password' => 'dariop',
            'password_repeat' => 'dariop'
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/users/add', $data);

        $this->assertResponseOk();
        $this->assertEquals('error', json_decode($this->_getBodyAsString())->type);
        $this->assertEquals($countOld, $this->Users->find()->count());
    }

    public function testAddGetRequest()
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->get('/API/users/add');

        $this->assertResponseError();
    }

    public function testAddNoData()
    {
        $countOld = $this->Users->find()->count();

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/users/add', []);

        $this->assertResponseOk();
        $this->assertEquals('error', json_decode($this->_getBodyAsString())->type);
        $this->assertEquals($countOld, $this->Users->find()->count());
    }

    public function testLoginOk()
    {
        $username = 'pippo@b.it';

        $oldUser = $this->Users->find()
            ->where(['Users.username' => $username])

            ->first();

        $data = [
            'username' => $username,
            'password' => 'dario',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/users/login', $data);

        $user = $this->Users->find()
            ->where(['Users.username' => $username])
            ->first();

        $this->assertResponseOk();

        // New Token assigned
        $this->assertNotEquals($oldUser->token, $user->token);
        $this->assertEquals($user->token, json_decode($this->_getBodyAsString())->token);
    }

    public function testLoginWrongPassword()
    {
        $username = 'pippo@b.it';

        $oldUser = $this->Users->find()
            ->where(['Users.username' => $username])

            ->first();

        $data = [
            'username' => $username,
            'password' => 'WRONG',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/users/login', $data);

        $user = $this->Users->find()
            ->where(['Users.username' => $username])
            ->first();

        $this->assertResponseOk();

        // No new Token assigned
        $this->assertEquals($oldUser->token, $user->token);
        $this->assertEmpty(json_decode($this->_getBodyAsString())->token);
        $this->assertEmpty(json_decode($this->_getBodyAsString())->auth);
    }

     public function testLoginWrongUsername()
    {
        $username = 'WRONG@b.it';

        $oldUser = $this->Users->find()
            ->where(['Users.username' => $username])
            ->first();

        $data = [
            'username' => $username,
            'password' => 'dario',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/users/login', $data);

        $this->assertResponseOk();

        $this->assertEmpty($oldUser);
        $this->assertEmpty(json_decode($this->_getBodyAsString())->token);
        $this->assertEmpty(json_decode($this->_getBodyAsString())->auth);
    }
}
