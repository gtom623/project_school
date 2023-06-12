<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateStudents extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('students');
        $table->addColumn('first_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('last_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('gender', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('school_class_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('language_group', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addForeignKey('school_class_id', 'school_classes', 'id',['delete'=> 'CASCADE', 'update'=> 'NO_ACTION']);
        $table->create();
    }
}
