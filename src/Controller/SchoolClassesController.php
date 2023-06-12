<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * SchoolClasses Controller
 *
 * @property \App\Model\Table\SchoolClassesTable $SchoolClasses
 * @method \App\Model\Entity\SchoolClass[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SchoolClassesController extends AppController
{
    /**
     * Index method
     *
     * Fetches and paginates the list of school classes. Sets the result to be used in the view.
     *
     * @return \Cake\Http\Response|null|void Renders the view.
     */
    public function index()
    {
        try {

            $this->paginate = [
                'contain' => ['Teachers'],

            ];
            $schoolClasses = $this->paginate($this->SchoolClasses);

            $this->set(compact('schoolClasses'));
        } catch (\Throwable $e) {
            $this->Flash->error(__('An error occurred while fetching the list of school classes.'));
            return $this->redirect(['controller' => 'Error', 'action' => 'customError']);
        }
    }

    /**
     * View method
     *
     * Retrieves and displays details of a specific school class based on the provided ID.
     * Includes related teachers and students. Sorts students based on query parameters.
     * Redirects to the index page on error.
     *
     * @param string $id School Class ID.
     * @return \Cake\Http\Response|null|void Renders the view.
     */
    public function view($id)
    {
        try {
            $schoolClass = $this->SchoolClasses->get($id, [
                'contain' => ['Teachers', 'Students'],
            ]);

            $sort = $this->request->getQuery('sort', 'gender');
            $direction = $this->request->getQuery('direction', 'asc');

            if ($schoolClass->students) {
                $sortedStudents = $schoolClass->students;
                usort($sortedStudents, function ($a, $b) use ($sort, $direction) {
                    if ($direction === 'asc') {
                        return strcmp($a->{$sort}, $b->{$sort});
                    } else {
                        return strcmp($b->{$sort}, $a->{$sort});
                    }
                });
                $schoolClass->set('students', $sortedStudents);
            }

            $this->set(compact('schoolClass'));
        } catch (\InvalidArgumentException $e) {
            $this->Flash->error($e->getMessage());
            return $this->redirect(['action' => 'index']);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Class not found.'));
            return $this->redirect(['action' => 'index']);
        } catch (\Throwable $e) {
            \Cake\Log\Log::error('An unexpected error occurred: ' . $e->getMessage());
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Add method
     *
     * Creates a new school class entry. On success, redirects to the index page with a success message.
     * On failure, renders the view with an error message.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        try {
            $schoolClass = $this->SchoolClasses->newEmptyEntity();
            if ($this->request->is('post')) {
                $schoolClass = $this->SchoolClasses->patchEntity($schoolClass, $this->request->getData());
                if ($this->SchoolClasses->save($schoolClass)) {
                    $this->Flash->success(__('The school class has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The school class could not be saved. Please, try again.'));
            }
            $teachers = $this->SchoolClasses->Teachers->find('list', [
                'keyField' => 'id',
                'valueField' => function ($teacher) {
                    return $teacher->first_name . ' ' . $teacher->last_name;
                }
            ])
                ->notMatching('SchoolClasses')
                ->all();

            $availableClasses = Configure::read('SchoolClasses');

            $existingClassesQuery = $this->SchoolClasses->find('list', ['valueField' => 'name']);
            $existingClasses = $existingClassesQuery->toArray();

            $missingClasses = array_diff($availableClasses, $existingClasses);

            $this->set(compact('schoolClass', 'teachers', 'missingClasses'));
            /**
             * error handling
             */
        } catch (\InvalidArgumentException $e) {
            $this->Flash->error($e->getMessage());
            return $this->redirect(['action' => 'index']);
        } catch (\Throwable $e) {
            \Cake\Log\Log::error('An unexpected error occurred: ' . $e->getMessage());
            $this->Flash->error(__('An unexpected error occurred. Please try again later.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Edit method
     *
     * Updates an existing school class entry based on the provided ID.
     * Redirects to the index page with a success message on successful edit, or with an error message on failure.
     *
     * @param string $id School Class ID.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function edit($id)
    {
        try {
            $schoolClass = $this->SchoolClasses->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $schoolClass = $this->SchoolClasses->patchEntity($schoolClass, $this->request->getData());
                if ($this->SchoolClasses->save($schoolClass)) {
                    $this->Flash->success(__('The school class has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The school class could not be saved. Please, try again.'));
            }
            $teachers = $this->SchoolClasses->Teachers->find('list', [
                'keyField' => 'id',
                'valueField' => function ($teacher) {
                    return $teacher->first_name . ' ' . $teacher->last_name;
                }
            ])
                ->notMatching('SchoolClasses')
                ->all();

            $availableClasses = Configure::read('SchoolClasses');

            $existingClassesQuery = $this->SchoolClasses->find('list', ['valueField' => 'name']);
            $existingClasses = $existingClassesQuery->toArray();

            $missingClasses = array_diff($availableClasses, $existingClasses);

            $this->set(compact('schoolClass', 'teachers', 'missingClasses'));
            /**
             * error handling
             */
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Class not found.'));
            return $this->redirect(['action' => 'index']);
        } catch (\Throwable $e) {
            \Cake\Log\Log::error('An unexpected error occurred: ' . $e->getMessage());
            $this->Flash->error(__('An unexpected error occurred. Please try again later.'));
            return $this->redirect(['action' => 'index']);
        }
    }
    /**
     * Delete method
     *
     * Deletes a school class based on the provided ID. Redirects to the index page.
     *
     * @param string|null $id School Class ID.
     * @return \Cake\Http\Response|null|void Redirects to the index page.
     */
    public function delete($id)
    {
        try {
            if (empty($id) || !is_numeric($id)) {
                throw new \InvalidArgumentException(__('Invalid school class ID.'));
            }
            $this->request->allowMethod(['post', 'delete']);
            $schoolClass = $this->SchoolClasses->get($id);
            if ($this->SchoolClasses->delete($schoolClass)) {
                $this->Flash->success(__('The school class has been deleted.'));
            } else {
                $this->Flash->error(__('The school class could not be deleted. Please, try again.'));
            }
            /**
             * error handling
             */
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Class not found.'));
        } catch (\Throwable $e) {
            \Cake\Log\Log::error('An unexpected error occurred: ' . $e->getMessage());
            $this->Flash->error(__('An unexpected error occurred. Please try again later.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
