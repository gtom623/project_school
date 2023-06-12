<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Faker\Factory;

class FackerController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }    
    /**
     * Method generateAllData
     *
     * The method fills the database with random data.
     * @return void
     */
    public function generateAllData()
    {
        $faker = Factory::create();
        $this->truncateTables();
        
        $knownCharacters = [
            ['Arnold', 'Schwarzenegger','Male'],
            ['Sherlock', 'Holmes','Male'],
            ['James', 'Bond','Male'],
            ['Indiana', 'Jones','Male'],
            ['Luke', 'Skywalker','Male'],
            ['Frodo', 'Baggins','Male'],
            ['Uma', 'Thurman','Female'],
            ['Angelina', 'Jolie','Female'],

        ];

        $this->Teachers = $this->getTableLocator()->get('Teachers');
        $this->Students = $this->getTableLocator()->get('Students');
        $this->SchoolClasses = $this->getTableLocator()->get('SchoolClasses');
 

        
        foreach($knownCharacters as $character) {
            $teacher = $this->Teachers->newEmptyEntity();
            $teacher->first_name = $character[0];
            $teacher->last_name = $character[1];
            $this->Teachers->save($teacher);
        }

       
     $classes =[1 => '1A', '1B', '1C', '1D', '1E', '1F'];      
        foreach  ($classes as $number => $class) {
            $schoolClass = $this->SchoolClasses->newEmptyEntity();
            $schoolClass->name = $class;
            $schoolClass->teacher_id = $number;
            $this->SchoolClasses->save($schoolClass);
        }



        for ($i = 0; $i < 180; $i++) {
            $gender = (rand(0, 1) == 0) ? 'Male' : 'Female';
            $lang = (rand(0, 1) == 0) ? 'english' : 'german';
            $student = $this->Students->newEmptyEntity();
            $student->first_name = $faker->firstName($gender);
            $student->last_name = $faker->lastName;
            $student->gender = mb_strtolower($gender);
            $student->school_class_id = $faker->randomElement(['1', '2', '3', '4', '5', '6']);
            $student->language_group =  $lang;
            $this->Students->save($student);
        }
        if ($this->Students->save($student) === false) {
            debug($student->getErrors());
        }

        $this->Flash->success(__('The database was randomly populated'));
        return $this->redirect(['controller' => 'Students', 'action' => 'index']);
    }    
    /**
     * Method truncateTables
     *
     * The database cleanup method
     * @return void
     */
    public function truncateTables(): void
    {
  
        $connection = ConnectionManager::get('default');
        
   
        $tables = ['teachers', 'students', 'school_classes'];

        $connection->execute('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tables as $table) {
            $connection->execute("TRUNCATE TABLE {$table}");
        }
        $connection->execute('SET FOREIGN_KEY_CHECKS = 1;');
        $this->Flash->success(__('The database has been cleared'));
    }
}