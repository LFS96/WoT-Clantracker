<?php

namespace App\Controller;

use App\Logic\Config\WgApi;
use App\Logic\Helper\ClanLangHelper;
use App\Logic\Helper\Speach2Lang;
use App\Logic\Helper\WgPlayers;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;
use LanguageDetector\LanguageDetector;

class ImportController extends AppController
{

    public function url($full = false)
    {
        if (!is_bool($full)) {
            $full = $full == 1;
        }

        $urls = [];
        //region GetAllPlayers
        $connection = ConnectionManager::get('default');

        $WHERE = ($full) ? '' : 'WHERE `player2` > 10';

        $clans = $connection->execute('
            SELECT player, count(*) as clans, sum(player) as sumPlayers
                FROM (SELECT c.id,
                             tag,
                             floor(count(*) / 2) * 2                                     as player,
                             (sum(if(p.lastBattle > curdate() - interval 30 day, 1, 0))) as player2
                      FROM clans c
                      INNER join players p on c.id = p.clan_id
                      GROUP BY c.id
                      ORDER BY player2 desc) as t
                ' . $WHERE . '
                GROUP BY player
                ORDER BY player ;')
            ->fetchAll('assoc');

        $from = -1;
        $to = 0;
        $sum = 0;
        $split = 2000;
        foreach ($clans as $clan) {
            if ($sum > $split) {
                $urls[] = Router::url(['controller' => 'import', 'action' => 'getAllPlayers', $full ? 1 : 0, $from, ($clan['player'] - 1)], true);
                $from = -1;
                $sum = 0;
            }
            if ($from == -1) {
                $from = $clan['player'];
            }
            $to = $clan['player'];
            $sum += $clan['clans'];
        }
        //lastStep
        $urls[] = Router::url(['controller' => 'import', 'action' => 'getAllPlayers', $full ? 1 : 0, $from, $to], true);
        //endregion

        // get Clans newly found in players history
        $urls[] = Router::url(['controller' => 'import', 'action' => 'getClansFromHistory'], true);

        if ($full) {
            // get Clans from random 100 players history
            $urls[] = Router::url(['controller' => 'import', 'action' => 'getNewClans', 100], true);
        }

        // recognize clans language
        $urls[] = Router::url(['controller' => 'import', 'action' => 'performLangAnalysis', $full?1:0], true);

        //debug($urls);
        $this->set('urls', $urls);
        // Specify which view vars JsonView should serialize.
        $this->viewBuilder()->setOption('serialize', 'urls')->setClassName('Json');
    }

    public function performLangAnalysis($mode = 0)
    {
        /**
         * 0 => fast
         * 1 => full
         */


        $good = array();
        $bad = array();

        $ClanLangHelper = new ClanLangHelper();
        $ClanLangHelper->getClansLangs($mode, $good, $bad);

        $this->set(compact('good', 'bad'));


    }

    public function getAllPlayers($full,$from = 0, $to = 100)
    {
        $full = $full == 1;

        $wgPlayers = new WgPlayers();
        $wgPlayers->getPlayersFromWG($full,$from, $to);
    }

    public function getNewClans($limit = 100)
    {
        $wgPlayers = new WgPlayers();

        $limit = ($limit <= 0) ? 100 : (($limit > 1000) ? 1000 : $limit);

        $this->set("messages", $wgPlayers->getNewClansViaPlayerHistory($limit));
    }

    public function getClansFromHistory()
    {
        $wgPlayers = new WgPlayers();

        $this->set("messages", $wgPlayers->importClansFormHistory());
    }
}
