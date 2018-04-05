<?php
namespace API\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'username' => ['type' => 'string', 'length' => 127, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null, 'fixed' => null],
        'role_id' => ['type' => 'integer', 'length' => 3, 'unsigned' => true, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'password' => ['type' => 'string', 'length' => 127, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 127, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null, 'fixed' => null],
        'surname' => ['type' => 'string', 'length' => 127, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'code' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null, 'fixed' => null],
        'ip' => ['type' => 'string', 'length' => 127, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null, 'fixed' => null],
        'token' => ['type' => 'string', 'length' => 63, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_bin'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'username' => 'pippo@b.it',
            'role_id' => 1,
            'password' => '$2y$10$4nOGiBncwER5VZRq5YRmheTQjTDI5B9iAbd.b1sxqV.NIR4/17E66',
            'name' => 'Dario',
            'surname' => 'La Padula',
            'created' => '2018-04-05 13:05:08',
            'modified' => '2018-04-05 13:05:08',
            'code' => '12345',
            'ip' => '127.0.0.1',
            'token' => '1234-5678'
        ],
        [
            'id' => 2,
            'username' => 'pippo2@b.it',
            'role_id' => 1,
            'password' => '$2y$10$4nOGiBncwER5VZRq5YRmheTQjTDI5B9iAbd.b1sxqV.NIR4/17E66',
            'name' => 'Dario',
            'surname' => 'La Padula',
            'created' => '2018-04-05 13:05:08',
            'modified' => '2018-04-05 13:05:08',
            'code' => '6789',
            'ip' => '127.0.0.1',
            'token' => '1234-5678-9101'
        ],
    ];
}
