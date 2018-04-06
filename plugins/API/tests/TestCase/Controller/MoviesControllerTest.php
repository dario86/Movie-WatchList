<?php namespace API\Test\TestCase\Controller;

use API\Controller\MoviesController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * API\Controller\MoviesController Test Case
 */
class MoviesControllerTest extends IntegrationTestCase
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

        // $this->now = Time::getTestNow();
        // $this->locale = Time::getDefaultLocale();

        $this->Movies = TableRegistry::get('API.Movies');
        $this->MoviesUsers = TableRegistry::get('API.MoviesUsers');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        \Cake\Cache\Cache::clear(false);
    }

    public function testAddOk()
    {
        // Simulating Ajax request
        $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $token = '1234-5678';

        $oldMoviesCount = $this->Movies->find()->count();
        $oldMoviesUsersCount = $this->MoviesUsers->find()->count();

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        // New Movie
        $data = [
            'title' => "Avengers",
            'watched' => '0',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/add', $data);

        // last association
        $mu = $this->MoviesUsers->find()
            ->contain(['Movies'])
            ->orderDesc('MoviesUsers.id')
            ->first();

        $this->assertResponseOk();
        $this->assertEquals('success', json_decode($this->_getBodyAsString())->type);
        $this->assertEquals($oldMoviesCount + 1, $this->Movies->find()->count());
        $this->assertEquals($oldMoviesUsersCount + 1, $this->MoviesUsers->find()->count());

        $this->assertEquals('Avengers', $mu->movie->title);
        $this->assertEquals(1, $mu->user_id);
        $this->assertEquals(0, $mu->watched);
    }

    public function testAddMovieExists()
    {
        // Simulating Ajax request
        $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $token = '1234-5678';

        $oldMoviesCount = $this->Movies->find()->count();
        $oldMoviesUsersCount = $this->MoviesUsers->find()->count();

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        // New Movie
        $data = [
            'title' => 'L\'uomo d\'acciaio',
            'watched' => '0',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/add', $data);

        // last association
        $mu = $this->MoviesUsers->find()
            ->contain(['Movies'])
            ->orderDesc('MoviesUsers.id')
            ->first();

        $this->assertResponseOk();
        $this->assertEquals('success', json_decode($this->_getBodyAsString())->type);
        $this->assertEquals($oldMoviesCount, $this->Movies->find()->count());
        $this->assertEquals($oldMoviesUsersCount + 1, $this->MoviesUsers->find()->count());

        $this->assertEquals('L\'uomo d\'acciaio', $mu->movie->title);
        $this->assertEquals(1, $mu->user_id);
        $this->assertEquals(0, $mu->watched);
    }

    public function testAddMovieUserExists()
    {
        // Simulating Ajax request
        $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $token = '1234-5678';

        $oldMoviesCount = $this->Movies->find()->count();
        $oldMoviesUsersCount = $this->MoviesUsers->find()->count();

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        // New Movie
        $data = [
            'title' => 'Franco, Ciccio e il Pirata Barbanera',
            'watched' => '0',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/add', $data);

        $this->assertResponseOk();
        $this->assertEquals('error', json_decode($this->_getBodyAsString())->type);
        $this->assertEquals($oldMoviesCount, $this->Movies->find()->count());
        $this->assertEquals($oldMoviesUsersCount, $this->MoviesUsers->find()->count());
    }

    public function testAddWrongMovie()
    {
        // Simulating Ajax request
        $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $token = '1234-5678';

        $oldMoviesCount = $this->Movies->find()->count();
        $oldMoviesUsersCount = $this->MoviesUsers->find()->count();

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        // New Movie
        $data = [
            'title' => 'ABCDE132456WRONG',
            'watched' => '0',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/add', $data);

        $this->assertResponseOk();
        $this->assertEquals('error', json_decode($this->_getBodyAsString())->type);
        $this->assertEquals($oldMoviesCount, $this->Movies->find()->count());
        $this->assertEquals($oldMoviesUsersCount, $this->MoviesUsers->find()->count());
    }

    public function testAddNotFound()
    {
        // Simulating Ajax request
       $_ENV['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
       $token = 'NOT_FOUND';

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        // New Movie
        $data = [
            'title' => "Avengers",
            'watched' => '0',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/add', $data);

        $this->assertResponseError();
    }
    
    public function testAddNoAjax()
    {
        $_ENV['HTTP_X_REQUESTED_WITH'] = null;
        $token = '1234-5678';

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        // New Movie
        $data = [
            'title' => "Avengers",
            'watched' => '0',
        ];

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/add', $data);

        $this->assertResponseError();
    }



    public function testSearchOk()
    {
        $token = '1234-5678';

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/search', []);

        $this->assertResponseOk();
        $this->assertNotEmpty(json_decode($this->_getBodyAsString())->data);
        $this->assertEquals(1, count(json_decode($this->_getBodyAsString())));
    }

    public function testDeleteOk()
    {
        $token = '1234-5678';

        $oldMoviesCount = $this->Movies->find()->count();
        $oldMoviesUsersCount = $this->MoviesUsers->find()->count();

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/delete', ['id' => 1]);

        $mu = $this->MoviesUsers->find()
            ->where(['MoviesUsers.id' => 1])
            ->first();

        $this->assertResponseOk();
        $this->assertEquals(1, $this->_getBodyAsString());
        $this->assertEquals($oldMoviesCount, $this->Movies->find()->count());
        $this->assertEquals($oldMoviesUsersCount - 1, $this->MoviesUsers->find()->count());
    }

    public function testDeleteWrongUser()
    {
        $token = '1234-5678';

        $oldMoviesCount = $this->Movies->find()->count();
        $oldMoviesUsersCount = $this->MoviesUsers->find()->count();

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/delete', ['id' => 2]);

        $mu = $this->MoviesUsers->find()
            ->where(['MoviesUsers.id' => 2])
            ->first();

        $this->assertResponseOk();
        $this->assertEquals(-1, $this->_getBodyAsString());
        $this->assertEquals($oldMoviesCount, $this->Movies->find()->count());
        $this->assertEquals($oldMoviesUsersCount, $this->MoviesUsers->find()->count());
    }

    public function testDeleteNotValidId()
    {
        $token = '1234-5678';

        $oldMoviesCount = $this->Movies->find()->count();
        $oldMoviesUsersCount = $this->MoviesUsers->find()->count();

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/delete', ['id' => 999]);

        $this->assertResponseOk();
        $this->assertEquals(-1, $this->_getBodyAsString());
        $this->assertEquals($oldMoviesCount, $this->Movies->find()->count());
        $this->assertEquals($oldMoviesUsersCount, $this->MoviesUsers->find()->count());
    }

    public function testDeleteNotWrongAuth()
    {
        $token = 'WRONG';

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/delete', ['id' => 999]);

        $this->assertResponseError();
    }

    public function testSetWatchedOk()
    {
        $token = '1234-5678';

        $oldMu = $this->MoviesUsers->find()
            ->where(['MoviesUsers.id' => 1])
            ->first();

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/setWatched', ['id' => 1, 'watched' => false]);


        $mu = $this->MoviesUsers->find()
            ->where(['MoviesUsers.id' => 1])
            ->first();


        $this->assertResponseOk();
        $this->assertEquals(1, $this->_getBodyAsString());
        $this->assertEquals(false, $mu->watched);
        $this->assertNotEquals($oldMu->watched, $mu->watched);
    }

    public function testSetWatchedNotValidId()
    {
        $token = '1234-5678';

        $oldMu = $this->MoviesUsers->find()
            ->where(['MoviesUsers.id' => 999])
            ->first();

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/setWatched', ['id' => 999, 'watched' => true]);


        $mu = $this->MoviesUsers->find()
            ->where(['MoviesUsers.id' => 999])
            ->first();

        $this->assertResponseOk();
        $this->assertEquals(-1, $this->_getBodyAsString());
        $this->assertEmpty($mu);
    }

    public function testSetWatchedWrongAuth()
    {
        $token = 'WRONG';

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/setWatched', ['id' => 2, 'watched' => true]);


        $this->assertResponseError();
    }

    public function testSetWatchedWrongUser()
    {
        $token = '1234-5678';

        $oldMu = $this->MoviesUsers->find()
            ->where(['MoviesUsers.id' => 2])
            ->first();

        $this->configRequest([
            'headers' => ['Authorization' => $token]
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->post('/API/movies/setWatched', ['id' => 2, 'watched' => true]);


        $mu = $this->MoviesUsers->find()
            ->where(['MoviesUsers.id' => 2])
            ->first();

        $this->assertResponseOk();
        $this->assertEquals(-1, $this->_getBodyAsString());
        $this->assertEquals(false, $mu->watched);
        $this->assertEquals($oldMu->watched, $mu->watched);
    }
}
