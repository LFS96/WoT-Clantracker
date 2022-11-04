<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClansTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClansTable Test Case
 */
class ClansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ClansTable
     */
    protected $Clans;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Clans',
        'app.History',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Clans') ? [] : ['className' => ClansTable::class];
        $this->Clans = $this->getTableLocator()->get('Clans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Clans);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ClansTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
