<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OfficersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OfficersTable Test Case
 */
class OfficersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OfficersTable
     */
    protected $Officers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Officers',
        'app.Complaints',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Officers') ? [] : ['className' => OfficersTable::class];
        $this->Officers = $this->getTableLocator()->get('Officers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Officers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\OfficersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
