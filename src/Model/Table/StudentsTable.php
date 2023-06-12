<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Students Model
 *
 * @property \App\Model\Table\SchoolClassesTable&\Cake\ORM\Association\BelongsTo $SchoolClasses
 *
 * @method \App\Model\Entity\Student newEmptyEntity()
 * @method \App\Model\Entity\Student newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Student[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Student get($primaryKey, $options = [])
 * @method \App\Model\Entity\Student findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Student patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Student[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Student|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class StudentsTable extends Table
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

        $this->setTable('students');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SchoolClasses', [
            'foreignKey' => 'school_class_id',
            'joinType' => 'INNER',
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

        $validator
            ->scalar('gender')
            ->maxLength('gender', 255)
            ->requirePresence('gender', 'create')
            ->notEmptyString('gender');

        $validator
            ->integer('school_class_id')
            ->notEmptyString('school_class_id');

        $validator
            ->scalar('language_group')
            ->maxLength('language_group', 255)
            ->requirePresence('language_group', 'create')
            ->notEmptyString('language_group');

        return $validator;
    }

    /**
     * Method for retrieving students from the database based on class and language
     *
     * @param string $className Description: The class name identifier, e.g., "1A".
     * @param string $sort Description: The attribute by which the data should be sorted, e.g., "gender".
     * @param string $direction Description: The direction in which the data should be sorted. Accepts "asc" for ascending or "desc" for descending.
     * @param ?string $languageGroup Description: (Optional) The language group identifier, e.g., "english". Null if not provided.
     *
     * @return Cake\Datasource\ResultSetInterface
     */
    /**
     * Retrieves students by class name and language group.
     *
     * @param string $className Name of the school class.
     * @param string $sort Sorting field.
     * @param string $direction Sorting direction.
     * @param string|null $languageGroup Language group.
     * @return \Cake\ORM\Query The query object.
     */
    public function getStudentsByClassAndLanguage(string $className, string $sort, string $direction, ?string $languageGroup)
    {
        $query = $this->find()
            ->contain(['SchoolClasses'])
            ->where(['SchoolClasses.name' => $className]);

        if ($languageGroup) {
            $query->where(['students.language_group' => $languageGroup]);
        }

        $query->order([$sort => $direction]);

        return $query->all();
    }
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('school_class_id', 'SchoolClasses'), ['errorField' => 'school_class_id']);

        return $rules;
    }
}