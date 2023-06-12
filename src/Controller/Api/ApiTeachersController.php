<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use OpenApi\Annotations as OA;

/**
 * ApiStudents Controller
 *
 * @property \App\Model\Table\StudentsTable $Students
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class ApiTeachersController extends AppController
{



    public function initialize(): void
    {
        parent::initialize();
        $this->Teachers = $this->getTableLocator()->get('Teachers');
    }

    /**
     * @OA\Tag(
     *     name="Teachers",
     *     description="Informations about teachers"
     * )
     * 
     *
     * @OA\Get(
     *     path="/api/teachers",
     *         tags={"Teachers"},    
     *         @OA\Parameter(
     *         name="extras",
     *         in="query",
     *         description="Additional extra information may include parameters (after a comma): class_information, students_details",         
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *                     
     * )
     *     ),
     *     @OA\Response(response="200", description="List of teachers"),
     *     @OA\Response(response="400", description="Invalid request"),
     *     @OA\Response(response="404", description="Teachers not found"),
     *     operationId="getTeachers",
     *     summary="Get list of teachers",
     *     description="Returns a list of teachers and extra information if is set."
     * )
     */


    /**
     * Index method
     *
     * Retrieves teachers with optional extra information based on input parameters.
     * Supports 'class_information' and 'students_details' as valid extra parameters.
     *
     * @return \Cake\Http\Response|null|void Renders view.
     */
    public function index()
    {

        /*
        Get and process input parameters
        */
        $extras = $this->request->getQuery('extras');
        if ($extras) {
            $extrasArray = explode(',', $extras);
        } else
            $extrasArray = null;
        /*
        Validate input parameters
        */
        $validationError = $this->validateExtras($extrasArray);
        if ($validationError) {
            return $this->response
                ->withStatus($validationError['status'])
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => $validationError['message'], 'valid_parameters' => $validationError['valid_parameters'] ?? null]))
                ->withStatus(400);
        }
        /*
        Perform database query
        */
        if (empty($extrasArray)) {
            $teachers = $this->Teachers->noExtrasParameter();
        } else if (count($extrasArray) === 1) {

            if ($extrasArray[0] === 'class_information') {
                $teachers = $this->Teachers->singleClassInformation();
            } elseif ($extrasArray[0] === 'students_details') {
                $teachers = $this->Teachers->singleStudentsDetails();
            }
        } else if (count($extrasArray) === 2) {
            if (in_array('class_information', $extrasArray) && in_array('students_details', $extrasArray)) {
                $teachers = $this->Teachers->multipleExtrasParameter();
            }
        }
        /*
    Check if teachers are empty and return appropriate response
    */
        if (empty($teachers)) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Teachers not found']))
                ->withStatus(404);
        }
        /*
       Return data as JSON
       */
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($teachers))
            ->withStatus(200);
    }

    /**
     * Method for validating input parameters and returning validation errors.
     *
     * @param array|null $extrasArray Array of extra parameters.
     * @return array|null Validation error array or null if parameters are valid.
     */
    private function validateExtras(?array $extrasArray): ?array
    {
        if (empty($extrasArray)) {
            return null;
        } elseif (count($extrasArray) === 1) {
            if ($extrasArray[0] === 'class_information' || $extrasArray[0] === 'students_details') {
                return null;
            } else {

                return ['status' => 400, 'message' => 'Invalid  parameter.', 'valid_parameters' => 'class_information,students_details'];
            }
        } elseif (count($extrasArray) === 2) {
            if (in_array('class_information', $extrasArray) && in_array('students_details', $extrasArray)) {
                return null;
            } else {

                return ['status' => 400, 'message' => 'Invalid parameter.', 'valid_parameters' => 'class_information,students_details'];
            }
        } else {

            return ['status' => 400, 'message' => 'Too many parameters allowed, max 2 parameters.', 'valid_parameters' => 'class_information,students_details'];
        }
    }
}
