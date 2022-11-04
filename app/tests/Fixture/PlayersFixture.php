<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlayersFixture
 */
class PlayersFixture extends TestFixture
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
                'nickname' => 'Lorem ipsum dolor sit amet',
                'clan_id' => 1,
                'quit' => '2022-10-22 11:03:11',
                'lastBattle' => '2022-10-22 11:03:11',
            ],
        ];
        parent::init();
    }
}
