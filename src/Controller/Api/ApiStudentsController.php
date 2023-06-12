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


class ApiStudentsController extends AppController
{


    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->getTableLocator()->get('Students');
    }

    /**
     * @OA\Tag(
     *     name="Students",
     *     description="Informations about students"
     * )
     * 
     *
     * @OA\Get(
     *     path="/api/students",
     *          tags={"Students"},      
     *         @OA\Parameter(
     *         name="class_name",
     *         in="query",
     *         description="Class name",         
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             enum={"1A", "1B", "1C", "1D",  "1E", "1F"}            
     * )
     *     ),
     *     @OA\Parameter(
     *         name="language_group",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"english", "german"}        
     * )
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Sort by field. If this parameter is set, you can use the 'direction' parameter to specify the sort direction.",        
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"gender", "first_name", "last_name"}        
     * )
     *     ),
     *     @OA\Parameter(
     *         name="direction",
     *         in="query",
     *         description="Sort direction. Can be 'asc' or 'desc'. This parameter is used only if the 'sort' parameter is set.",        
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             enum={"asc", "desc"}        
     * )
     *     ),
     *     @OA\Response(response="200", description="List of students"),
     *     @OA\Response(response="400", description="Invalid request"),
     *     @OA\Response(response="404", description="Students not found"),
     *     operationId="getStudents",
     *     summary="Get list of students",
     *     description="Returns a list of students."
     * )
     */

    /**
     * Index method
     *
     * Retrieves a list of students based on input parameters.
     * Supports filtering by class name, sorting by specified field, and specifying the sort direction.
     * Optionally, a language group can be specified to further filter the results.
     *
     * @return \Cake\Http\Response Returns JSON response with student data.
     */
    public function index(): Response
    {

        /*
        Get and process input parameters
        */
        $className = $this->request->getQuery('class_name', '1A');
        $sort = $this->request->getQuery('sort', 'gender');
        $direction = $this->request->getQuery('direction', 'asc');
        $languageGroup = $this->request->getQuery('language_group');
        /*
        Validate input parameters
        */
        $validationError = $this->validateParameters($className, $sort, $direction, $languageGroup);
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
        $students = $this->Students->getStudentsByClassAndLanguage($className, $sort, $direction, $languageGroup);
        /*
    Check if teachers are empty and return appropriate response
    */
        if (empty($students)) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Students not found']))
                ->withStatus(404);
        }
        /*
        Return data as JSON
        */

        return $this->response->withType('application/json')->withStringBody(json_encode($students))->withStatus(200);
    }


    /**
     * Method for validating input parameters and returning validation errors.
     *
     * @param string $className The class name.
     * @param string $sort The field to sort by.
     * @param string $direction The sort direction.
     * @param string|null $languageGroup The language group.
     * @return array|null Validation error array or null if parameters are valid.
     */
    private function validateParameters(string $className, string $sort, string $direction, ?string $languageGroup): ?array
    {
        if (!$this->isValidSort($sort)) {
            return ['status' => 400, 'message' => 'Invalid sort parameter.', 'valid_parameters' => 'gender, first_name, last_name'];
        }

        if (!$this->isValidDirection($direction)) {
            return ['status' => 400, 'message' => 'Invalid direction parameter.', 'valid_parameters' => 'asc, desc'];
        }

        if (!$this->isValidClassName($className)) {
            return ['status' => 400, 'message' => 'Invalid class name.', 'valid_parameters' => '1A, 1B, 1C, 1D, 1E, 1F'];
        }

        if (!$this->isValidLanguageGroup($languageGroup)) {
            return ['status' => 400, 'message' => 'Invalid language group.'];
        }
        /*
        Return null if no validation errors detected
        */
        return null;
    }

    /**
     * Method for validating the 'sort' input parameter.
     *
     * @param string $sort The sort parameter.
     * @return bool True if the sort parameter is valid, false otherwise.
     */
    private function isValidSort(string $sort): bool
    {
        return in_array($sort, ['gender', 'first_name', 'last_name'], true);
    }

    /**
     * Method for validating the 'direction' input parameter.
     *
     * @param string $direction The direction parameter.
     * @return bool True if the direction parameter is valid, false otherwise.
     */
    private function isValidDirection(string $direction): bool
    {
        return in_array($direction, ['asc', 'desc'], true);
    }
    /**
     * Method for validating the 'class_name' input parameter.
     *
     * @param string $className The class name parameter.
     * @return bool True if the class name parameter is valid, false otherwise.
     */
    private function isValidClassName(string $className): bool
    {
        return $this->Students->SchoolClasses->exists(['name' => $className]);
    }
    /**
     * Method for validating the 'language_group' input parameter.
     *
     * @param string|null $languageGroup The language group parameter.
     * @return bool True if the language group parameter is valid, false otherwise.
     */
    private function isValidLanguageGroup(?string $languageGroup): bool
    {
        $languageGroups = Configure::read('LanguageGroups');
        return empty($languageGroup) || in_array($languageGroup, $languageGroups, true);
    }
}
