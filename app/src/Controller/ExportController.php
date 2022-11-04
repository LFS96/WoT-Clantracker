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

class ExportController extends AppController
{

    public function index($full = false)
    {
        $connection = ConnectionManager::get('default');
        $data = $connection->execute('
SELECT p.id, p.nickname, date(p.quit), date(p.lastBattle),
       (SELECT  tag FROM histories INNER JOIN clans c on histories.clan_id = c.id WHERE player_id = p.id ORDER BY joined desc limit 1) as lastClan,
       (SELECT  GROUP_CONCAT(DISTINCT lang_id) FROM histories INNER JOIN clans c on histories.clan_id = c.id WHERE player_id = p.id  ORDER BY joined ) as lang
FROM players p
WHERE p.clan_id is null AND p.lastBattle > curdate() - INTERVAL 30 DAY
ORDER BY date(p.quit) desc;')->fetchAll('assoc');
        $this->set('data', $data);
    }
}
