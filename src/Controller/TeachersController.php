<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\MethodNotAllowedException;

/**
 * Teachers Controller
 *
 * @property \App\Model\Table\TeachersTable $Teachers
 * @method \App\Model\Entity\Teacher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TeachersController extends AppController
{
    /**
     * Index method
     *
     * Fetches and paginates the list of teachers. Sets the result to be used in the view.
     *
     * @return \Cake\Http\Response|null|void Renders the view.
     */
    public function index()
    {
        try {
            $teachers = $this->paginate($this->Teachers);

            $this->set(compact('teachers'));
        } catch (\Throwable $e) {
            $this->Flash->error(__('An error occurred while fetching the list of students.'));
            return $this->redirect(['controller' => 'Error', 'action' => 'customError']);
        }
    }

    /**
     * View method
     *
     * Retrieves and displays details of a specific teacher based on the provided teacher ID.
     * Includes related school classes and counts the number of students in each class.
     * Redirects to the index page on error.
     *
     * @param string $id Teacher ID.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     */
    public function view($id)
    {
        try {

            $teacher = $this->Teachers->get($id, [
                'contain' => ['SchoolClasses'],
            ]);

            $numberOfStudents = 0;
            if (!empty($teacher->school_classes)) {
                foreach ($teacher->school_classes as $schoolClass) {
                    if ($schoolClass->id) {
                        $numberOfStudents = $this->Teachers->SchoolClasses->Students->find()
                            ->where(['school_class_id' => $schoolClass->id])
                            ->count();
                        $schoolClass->students_count = $numberOfStudents;
                    } else {
                        $schoolClass->students_count = 0;
                    }
                }
            }
            // else {
            $teacher->school_classes = [];
            // }
            $this->set(compact('teacher', 'numberOfStudents'));
            /**
             * error handling
             */
        } catch (\InvalidArgumentException $e) {
            $this->Flash->error($e->getMessage());
            return $this->redirect(['action' => 'index']);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Teacher not found.'));
            return $this->redirect(['action' => 'index']);
        } catch (\Throwable $e) {
            \Cake\Log\Log::error('An unexpected error occurred: ' . $e->getMessage());
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Add method
     *
     * Creates a new teacher entry. On success, redirects to the index page with a success message.
     * On failure, renders the view with an error message.
     *
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     */
    public function add()
    {
        try {
            $teacher = $this->Teachers->newEmptyEntity();
            if ($this->request->is('post')) {

                $teacher = $this->Teachers->patchEntity($teacher, $this->request->getData());
                if ($this->Teachers->save($teacher)) {
                    $this->Flash->success(__('The teacher has been saved.'));

                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The teacher could not be saved. Please, try again.'));
                }
            }

            $this->set(compact('teacher'));
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
     * Updates an existing teacher entry based on the provided ID.
     * Redirects to the index page with a success message on successful edit, or with an error message on failure.
     *
     * @param string $id Teacher ID.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     */
    public function edit($id = null)
    {


        try {
            if (empty($id) || !is_numeric($id)) {
                throw new \InvalidArgumentException(__('Invalid teacher ID.'));
            }
            $teacher = $this->Teachers->get($id, [
                'contain' => [],
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {

                $teacher = $this->Teachers->patchEntity($teacher, $this->request->getData());
                if ($this->Teachers->save($teacher)) {
                    $this->Flash->success(__('The teacher has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The teacher could not be saved. Please, try again.'));
            }

            $this->set(compact('teacher'));
            /**
             * error handling
             */
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Teacher not found.'));
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
     * Deletes a teacher based on the provided ID. Redirects to the index page.
     *
     * @param string $id Teacher ID.
     * @return \Cake\Http\Response|void Redirects to the index page.
     */
    public function delete($id)
    {
        try {
            if (empty($id) || !is_numeric($id)) {
                throw new \InvalidArgumentException(__('Invalid teacher ID.'));
            }
            $this->request->allowMethod(['post', 'delete']);
            $teacher = $this->Teachers->get($id);
            if ($this->Teachers->delete($teacher)) {
                $this->Flash->success(__('The teacher has been deleted.'));
            } else {
                $this->Flash->error(__('The teacher could not be deleted. Please, try again.'));
            }
            /**
             * error handling
             */
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Teacher not found.'));
        } catch (\Throwable $e) {
            \Cake\Log\Log::error('An unexpected error occurred: ' . $e->getMessage());
            $this->Flash->error(__('An unexpected error occurred. Please try again later.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
