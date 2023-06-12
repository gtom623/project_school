<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\SchoolClass;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Teachers Model
 *
 * @property \App\Model\Table\SchoolClassesTable&\Cake\ORM\Association\HasMany $SchoolClasses
 *
 * @method \App\Model\Entity\Teacher newEmptyEntity()
 * @method \App\Model\Entity\Teacher newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Teacher[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Teacher get($primaryKey, $options = [])
 * @method \App\Model\Entity\Teacher findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Teacher patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Teacher[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Teacher|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Teacher saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Teacher[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Teacher[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Teacher[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Teacher[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TeachersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('teachers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasOne('SchoolClasses', [
            'foreignKey' => 'teacher_id',
            'dependent' => false,
            'cascadeCallbacks' => false, 
        ]);

    }
  
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        return $validator;
    }
    /**
     * Method without input parameters
     *
     * Retrieves all teachers without any extra information.
     *
     * @return array Array of teachers.
     */
    public function noExtrasParameter(): array
    {
        $query = $this->find('all');
        return $query->toArray();
    }

    /**
     * Method for 1 input parameter 'ClassInformation'
     *
     * Retrieves teachers with their associated school classes. Removes empty school classes.
     *
     * @return array Array of teachers with associated school classes.
     */
    public function singleClassInformation(): array
{
    $query = $this->find('all')->contain(['SchoolClasses']);
    return $query->toArray();
}

    /**
     * Method for 1 input parameter 'StudentsDetails'
     *
     * Retrieves teachers with their associated school classes and students. Calculates the total number of male and female students.
     * Removes school classes from the result.
     *
     * @return array Array of teachers with associated students and total student counts.
     */
    public function singleStudentsDetails(): array
    {
        $query = $this->find('all')->contain(['SchoolClasses.Students']);
    
        foreach ($query as $teacher) {
            if ($teacher->school_class) {
                $counts = $this->countStudents($teacher->school_class);
                $teacher->total_male_students = $counts['male'];
                $teacher->total_female_students = $counts['female'];
                $teacher->total_students = $counts['total'];
           unset($teacher->school_class);
            }
        }
    
        return $query->toArray();
    }

    /**
     * Method for 2 input parameters
     *
     * Retrieves teachers with their associated school classes and students. Calculates the total number of male and female students.
     * Removes students from the result.
     *
     * @return array Array of teachers with associated school classes and total student counts.
     */
    public function multipleExtrasParameter(): array
{
    $query = $this->find('all')
        ->contain(['SchoolClasses'])
        ->contain(['SchoolClasses.Students']);

    foreach ($query as $teacher) {
        $counts = $this->countStudents($teacher->school_class);
        $teacher->total_male_students = $counts['male'];
        $teacher->total_female_students = $counts['female'];
        $teacher->total_students = $counts['total'];
        
        if ($teacher->school_class) {
            unset($teacher->school_class->students);
        }
        
        if (empty($teacher->school_class)) {
            unset($teacher->school_class);
        }
    }
    
    return $query->toArray();
}
    /**
     * Method for counting students
     *
     * Counts the number of male and female students in the provided school classes.
     *
     * @param array $schoolClasses Array of school classes.
     * @return array Associative array with male, female, and total student counts.
     */
    private function countStudents($schoolClass): array
{
    $maleCount = 0;
    $femaleCount = 0;

    if ($schoolClass) {
        foreach ($schoolClass->students as $student) {
            if ($student->gender === 'male') {
                $maleCount++;
            } elseif ($student->gender === 'female') {
                $femaleCount++;
            }
        }
    }

    return [
        'male' => $maleCount,
        'female' => $femaleCount,
        'total' => $maleCount + $femaleCount
    ];
}
}