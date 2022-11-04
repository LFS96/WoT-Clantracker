<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HistoriesFixture
 */
class HistoriesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'player_id' => 1,
                'clan_id' => 1,
                'joined' => '2022-10-22 08:13:03',
            ],
        ];
        parent::init();
    }
}
