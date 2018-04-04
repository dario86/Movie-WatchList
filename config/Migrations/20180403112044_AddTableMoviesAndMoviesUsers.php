<?php
use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AddTableMoviesAndMoviesUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('movies')
            ->addColumn('external_id', 'integer', [
                'limit' => MysqlAdapter::INT_MEDIUM,
                'signed' => false,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->create();

         $this->table('movies_users')
            ->addColumn('user_id', 'integer', [
                'limit' => MysqlAdapter::INT_MEDIUM,
                'signed' => false,
                'null' => true,
            ])
            ->addColumn('movie_id', 'string', [
                'limit' => MysqlAdapter::INT_MEDIUM,
                'signed' => false,
                'null' => true,
            ])
            ->addColumn('watched', 'boolean', [
                'default' => 0,
                'null' => false
            ])
            ->addColumn('created', 'datetime', [
                'null' => true
            ])
            ->addColumn('modified', 'datetime', [
                'null' => true
            ])
            ->create();
    }
}
