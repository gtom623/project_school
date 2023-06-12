<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SchoolClassesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SchoolClassesTable Test Case
 */
class SchoolClassesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SchoolClassesTable
     */
    protected $SchoolClasses;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.SchoolClasses',
        'app.Teachers',
        'app.Students',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SchoolClasses') ? [] : ['className' => SchoolClassesTable::class];
        $this->SchoolClasses = $this->getTableLocator()->get('SchoolClasses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SchoolClasses);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SchoolClassesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SchoolClassesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
