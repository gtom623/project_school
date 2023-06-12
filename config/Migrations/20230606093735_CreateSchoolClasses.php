<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSchoolClasses extends AbstractMigration
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
        $table = $this->table('school_classes');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('teacher_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addForeignKey('teacher_id', 'teachers', 'id',['delete'=> 'CASCADE', 'update'=> 'NO_ACTION']);
        $table->create();
    }
}
