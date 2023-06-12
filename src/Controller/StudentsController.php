<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;
use Exception;

/**
 * Students Controller
 *
 * @property \App\Model\Table\StudentsTable $Students
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentsController extends AppController
{


    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $genderGroups = Configure::read('GenderGroups');
        $languageGroups = Configure::read('LanguageGroups');

        $this->set(compact('genderGroups', 'languageGroups'));
    }

    /**
     * Index method
     *
     * Fetches and paginates the list of students, including related school classes.
     * Sets the result to be used in the view.
     *
     * @return void
     */
    public function index()
    {

        try {
           
            $this->paginate = [
                'contain' => ['SchoolClasses'],
            ];
            $students = $this->paginate($this->Students);
        } catch (\Throwable $e) {
            $this->Flash->error(__('An error occurred while fetching the list of students.'));
            return $this->redirect(['controller' => 'Error', 'action' => 'customError']);
        }
        $this->set(compact('students'));
    }

    /**
     * View method
     *
     * Fetches and displays details of a specific student based on the provided student ID.
     * Includes related school classes in the result.
     * If an invalid ID is provided or an error occurs during retrieval, redirects back to the index page with an error message.
     *
     * @param string $id Student ID.
     * @return \Cake\Http\Response|null|void Renders the student details view or redirects to the index page in case of error.
     */
    public function view($id = null)
    {
        try {

            if (empty($id) || !is_numeric($id)) {
                throw new \InvalidArgumentException(__('Invalid student ID.'));
            }
            $student = $this->Students->get($id, [
                'contain' => ['SchoolClasses'],
            ]);

            $this->set(compact('student'));
            /**
             * error handling
             */
        } catch (\InvalidArgumentException $e) {
            $this->Flash->error($e->getMessage());
            return $this->redirect(['action' => 'index']);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Student not found.'));
            return $this->redirect(['action' => 'index']);
        } catch (\Throwable $e) {
            \Cake\Log\Log::error('An unexpected error occurred: ' . $e->getMessage());
            return $this->redirect(['action' => 'index']);
        }
    }
    /**
     * Add method
     *
     * Creates a new student entry. On success, redirects to the index page with a success message.
     * On failure, renders the view with an error message.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view with an error message on failure.
     */
    public function add()
    {
        try {
            $student = $this->Students->newEmptyEntity();

            $schoolClasses = $this->Students->SchoolClasses->find('list', ['limit' => 200])->all();

            if ($this->request->is('post')) {
                $student = $this->Students->patchEntity($student, $this->request->getData());
                if ($this->Students->save($student)) {
                    $this->Flash->success(__('The student has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The student could not be saved. Please, try again.'));
                }
            }
            $this->set(compact('student', 'schoolClasses'));
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
     * Updates an existing student entry based on the provided ID. 
     * Redirects to the index page with a success message on successful edit, or with an error message on failure.
     *
     * @param string $id Student ID.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view with an error message on failure.
     */
    public function edit($id)
    {
        try {
            $student = $this->Students->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $student = $this->Students->patchEntity($student, $this->request->getData());
                if ($this->Students->save($student)) {
                    $this->Flash->success(__('The student has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The student could not be saved. Please, try again.'));
            }
            $schoolClasses = $this->Students->SchoolClasses->find('list', ['limit' => 200])->all();
            $this->set(compact('student', 'schoolClasses'));
            /**
             * error handling
             */
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Student not found.'));
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
     * Deletes a student based on the provided ID. Redirects to the index page.
     *
     * @param string $id Student ID.
     * @return \Cake\Http\Response|null|void Redirects to the index page.
     */
    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);

        if ($id === null) {
            $this->Flash->error(__('Invalid student ID.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $student = $this->Students->get($id);
            if ($this->Students->delete($student)) {
                $this->Flash->success(__('The student has been deleted.'));
            } else {
                $this->Flash->error(__('The student could not be deleted. Please, try again.'));
            }
            /**
             * error handling
             */
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Student not found.'));
        } catch (\Throwable $e) {
            \Cake\Log\Log::error('An unexpected error occurred: ' . $e->getMessage());
            $this->Flash->error(__('An unexpected error occurred. Please try again later.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
