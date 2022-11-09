<?php

namespace App\Logic\Helper;

use App\Logic\Config\WgApi;
use App\Model\Entity\Player;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\ORM\TableRegistry;
use DateTime;

class WgPlayers
{
    // Get all current players from WG API
    public static function getPlayersFromWG($full, $min = 0, $max = 100)
    {
        //region Get Database Connection
        $api = WgApi::getWG_API();
        $Clans = TableRegistry::getTableLocator()->get('Clans');
        //endregion

        $full_user = $full ? 0 : 10;

        $clanList = $Clans
            ->find('all')
            ->innerJoin("players", "players.clan_id = clans.id")
            ->select([
                "id",
                "panz" => "count(*)",
                "paktiv" => "sum(if(players.lastBattle > CURDATE() - interval 30 day, 1, 0))",
            ])
            ->group("clans.id")
            ->having(["panz >" => $min, "panz <=" => $max, "paktiv >" => $full_user])
          ->toArray();
        $clanList = array_chunk($clanList, 100);
        foreach ($clanList as $list) {
            $list = implode(",", array_map(function ($item) {
                return $item->id;
            }, $list));
            //  Debugger::dump($list);
            $resp = $api->get("wot/clans/info/", array("clan_id" => $list, "fields" => "members"));
            if($resp != null) {
                foreach ($resp as $clan_id => $clan) {
                    self::addMembersToClan($clan_id, $clan);
                }
            }
        }
    }

    public static function importClansFormHistory(){
        $connection = ConnectionManager::get('default');
        $clans = $connection->execute("SELECT DISTINCT clan_id FROM histories h LEFT JOIN clans c on h.clan_id = c.id WHERE c.id is null ORDER BY joined desc;")->fetchAll('assoc');

        $Clan_liste = array();
        foreach($clans as $clan){
            $Clan_liste[] = $clan['clan_id'];
        }
        return (new WgPlayers)->importClans($Clan_liste);
    }


    public static function getNewClansViaPlayerHistory($limit = 100)
    {
        //region Connect to DB
        $api = WgApi::getWG_API();
        $PlayersTable = TableRegistry::getTableLocator()->get('Players');
        $ClansTable = TableRegistry::getTableLocator()->get('Clans');

        //endregion

        //region Get knwon clans, no need to check them again
        $knownClans = $ClansTable->find()->select(["id"])->toArray();
        $knownClans_array = [];
        foreach ($knownClans as $clan) {
            $knownClans_array[] = $clan->id;
        }
        //endregion

        $Clans = [];

        //region Get new Clans from Players History
        /** @var object{min:int, max:int} $minMax kleinst und Größte Spieler ID */
        $minMax = $PlayersTable->find()->select(["min" => $PlayersTable->find()->func()->min("id"), "max" => $PlayersTable->find()->func()->max("id")])->first();
        $rand = rand($minMax->min, $minMax->max);

        $Players = $PlayersTable->find()->limit($limit)->where(["id >" => $rand])->toArray();
        foreach ($Players as $player) {
            $history = $api->get("wot/clans/memberhistory/", array("account_id" => $player->id));
            if ($history != null) {
                foreach ($history->{$player->id} as $history_entry) {
                    //  debug($history_entry);
                    if (!in_array($history_entry->clan_id, $knownClans_array)) {
                        $Clans[$history_entry->clan_id] = $history_entry->clan_id;
                    }
                }
            }
        }
        //endregion
        // debug($Clans);

        $messages = [];
        return (new WgPlayers)->importClans($Clans, $messages);
    }

    public function importClans($Clans, $messages = []){
        $connection = ConnectionManager::get('default');
        $api = WgApi::getWG_API();
        $listen = array_chunk($Clans, 100);
        foreach ($listen as $list) {
            $list = implode(",", $list);
            //  Debugger::dump($list);
            $resp = $api->get("wot/clans/info/", array("clan_id" => $list, "fields" => "clan_id,name,tag,motto,description,members_count,members"));
            if($resp != null) {

                $statment = $connection->prepare("INSERT INTO clans (id, name, tag, description) VALUES (:id, :name, :tag, :description) ON DUPLICATE KEY UPDATE name = :name, tag = :tag, description = :description");
                foreach ($resp as $clan_id => $clan) {
                    if(isset($clan->name) && $clan->name) {
                        $messages [] =   "[" . $clan->tag . "] " . $clan->name ;
                        $statment->bindValue('id', $clan_id);
                        $statment->bindValue('name', $clan->name);
                        $statment->bindValue('tag', $clan->tag);
                        $statment->bindValue('description', $clan->motto.PHP_EOL.PHP_EOL.$clan->description);
                        $statment->execute();
                        if ($clan->members_count > 0) {
                            self::addMembersToClan($clan_id, $clan);
                        }
                    }
                }
            }
        }
        return $messages;
    }

    /**
     * @param int $clan_id
     * @param array $clan from WG API

     * @return void
     * @throws \Exception
     */
    private static function addMembersToClan($clan_id, $clan){
        $api = WgApi::getWG_API();
        $connection = ConnectionManager::get('default');
        $Players = TableRegistry::getTableLocator()->get('Players');

        $current_members = array();
        if(isset($clan->members)) {
            foreach ($clan->members as $members) {
                $current_members[] = $members->account_id;
            }
            if (count($current_members) > 0) {
                $players_details = $api->get("wot/account/info/", array("account_id" => implode(",", $current_members), "fields" => "account_id,clan_id,last_battle_time,nickname,updated_at"));

                //region Schreibe oder Update Spieler in DB
                $statement = $connection->prepare("INSERT INTO `players` (`id`, `nickname`, `clan_id`, `lastBattle`, `quit`) VALUES (:id, :nickname, :clan_id, :lastBattle, :quit) ON DUPLICATE KEY UPDATE nickname = :nickname, clan_id = :clan_id, lastBattle = :lastBattle, quit = :quit");
                foreach ($clan->members as $members) {
                    $statement->bindValue('id', $members->account_id);
                    $statement->bindValue('nickname', $members->account_name);
                    $statement->bindValue('clan_id', $clan_id);
                    $statement->bindValue('lastBattle', gmdate("Y-m-d H:i:s", $players_details->{$members->account_id}->last_battle_time));
                    $statement->bindValue('quit', null);
                    $statement->execute();
                }
                if ($players_details->{$members->account_id} == null) {
                    debug($players_details);
                    debug($members);
                }


                //endregion

                //region Finde alle Spieler die nicht mehr in dem Clan sind
                /** @var Player[] $austritte */
                $austritte = $Players->find()->where(['clan_id' => $clan_id])->where(function ($exp, $q) use ($current_members) {
                    return $exp->notIn('id', $current_members);
                })->toArray();
                //  debug($austritte);
                $users_ausgetreten = array();
                foreach ($austritte as $austritt) {
                    if ($austritt->id != null) {
                        $users_ausgetreten[] = $austritt->id;
                    }
                    //   $users_ausgetreten[] = $austritt->account_id;
                }
                //  debug($users_ausgetreten);
                if (count($users_ausgetreten) > 0) {

                    $ausgetren_list = implode(",", $users_ausgetreten);
                    //  debug($users_ausgetreten);
                    $players_details = $api->get("wot/account/info/", array("account_id" => $ausgetren_list, "fields" => "account_id,clan_id,last_battle_time,nickname,updated_at"));
                    foreach ($players_details as $player) {
                        $quit = null;
                        if ($player == null || !$player->account_id) {
                            continue;
                        }
                        if ($player->clan_id == null) {
                            //region Player has no clan, get history
                            $history = $api->get("wot/clans/memberhistory/", array("account_id" => $player->account_id));
                            $stmt_history = $connection->prepare(
                                "INSERT INTO `histories` (`player_id`, `clan_id`, `joined`)
                                VALUES ( :player_id, :clan_id, :joined_at)
                                ON DUPLICATE KEY
                                UPDATE player_id = :player_id, clan_id = :clan_id, joined = :joined_at");
                            foreach ($history->{$player->account_id} as $history_entry) {
                                $stmt_history->bindValue('player_id', $history_entry->account_id);
                                $stmt_history->bindValue('clan_id', $history_entry->clan_id);
                                $stmt_history->bindValue('joined_at', gmdate("Y-m-d H:i:s", $history_entry->joined_at));
                                $stmt_history->execute();

                                if ($quit == null || $quit < $history_entry->left_at) {
                                    $quit = $history_entry->left_at;
                                }
                            }
                            //endregion
                        }
                        $statement = $connection->prepare("UPDATE `players` SET quit = :quit, clan_id = :clan_id WHERE id = :id");
                        $statement->bindValue('id', $player->account_id);
                        $statement->bindValue('clan_id', $player->clan_id);
                        $statement->bindValue('quit', $quit == null ? null : gmdate("Y-m-d H:i:s", $quit));
                        $statement->execute();
                    }
                }
                //endregion
            }
        }
    }
}
