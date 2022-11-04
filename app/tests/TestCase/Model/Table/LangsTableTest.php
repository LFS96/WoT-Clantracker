<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LangsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LangsTable Test Case
 */
class LangsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LangsTable
     */
    protected $Langs;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Langs',
        'app.Clans',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Langs') ? [] : ['className' => LangsTable::class];
        $this->Langs = $this->getTableLocator()->get('Langs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Langs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LangsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
