<?php

namespace App\Logic\Helper;

use App\Logic\Config\WgApi;
use Cake\ORM\TableRegistry;
use LanguageDetector\LanguageDetector;

class ClanLangHelper
{
    public function getClansLangs($try_without_description = false, &$good = [],&$bad =[]){

        $clansTable = TableRegistry::getTableLocator()->get('Clans');

        $clans = $clansTable->find('all')->where(['lang_id IS' => null, 'description <>' => ''])->toArray();
        $langDetector = new LanguageDetector();
        foreach ($clans as $clan) {

            $lang = Speach2Lang::getLang($clan->description);

            if ($lang instanceof \App\Model\Entity\Lang) {
                $clan->lang_id = $lang->id;
                $clansTable->save($clan);
                $good[$clan->tag] = array( $lang->id, $clan->name, $clan->description);
            } else {
                if($lang != null){
                    $bad[$clan->tag] = $clan->name. ' - <strong>' . $lang. '</strong> - ' . $clan->description;
                }
            }

        }
        //  $this->set(compact('good', 'bad'));

        if($try_without_description) {
            $api = WgApi::getWG_API();
            $clans = $clansTable->find('all')->where(['lang_id IS' => null, 'description' => ''])->toArray();
            $clanList = array_chunk($clans, 100);
            foreach ($clanList as $list) {
                $list = implode(",", array_map(function ($item) {
                    return $item->id;
                }, $list));
                //  Debugger::dump($list);
                $resp = $api->get("wot/clans/info/", array("clan_id" => $list, "fields" => "motto,clan_id"));
                if ($resp != null) {
                    foreach ($resp as $clan_id => $clan) {
                        $lang = Speach2Lang::getLang($clan->motto);

                        $clan_entity = $clansTable->get($clan_id);
                        if ($clan_entity == null) {
                            echo 'Clan not found: ' . $clan_id . "<br>";
                            continue;

                        }
                        if ($lang instanceof \App\Model\Entity\Lang) {
                            $clan_entity = $clansTable->get($clan_id);
                            $clan_entity->lang_id = $lang->id;
                            $clansTable->save($clan_entity);
                            $good[$clan_entity->tag] = array($lang->id, $clan_entity->name, $clan_entity->description);
                        } else {
                            //  if($lang != null){
                            $bad[$clan_entity->tag] = $clan_entity->name . ' - <strong>' . $lang . '</strong> - ' . $clan->motto;
                            //  }
                        }
                    }
                }
            }
        }
    }
}
