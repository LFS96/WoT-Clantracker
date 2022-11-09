<?php

namespace App\Logic\Helper;

use App\Logic\Config\WgApi;
use Cake\ORM\TableRegistry;
use LanguageDetector\LanguageDetector;

class ClanLangHelper
{
    public function getClansLangs($mode = 0, &$good = [],&$bad =[]){

        $clansTable = TableRegistry::getTableLocator()->get('Clans');

        if($mode == 1) {
           $connection = \Cake\Datasource\ConnectionManager::get('default');
           $connection->execute('UPDATE clans SET lang_id= null WHERE length(description) <= 5');

           $clan_liste_obj= $clansTable->find()->where(['length(description) <=' => 5])->toArray();
            $clan_liste = array();
           foreach ($clan_liste_obj as $clan) {
               $clan_liste[] = $clan->id;
           }
           $clan_100_list = array_chunk($clan_liste, 100);
           foreach ($clan_100_list as $clan_100) {
               (new WgPlayers())->importClans($clan_100);
           }
        }


        $clans = $clansTable->find('all')->where(['lang_id IS' => null, 'length(description) >' => 5])->toArray();
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


    }
}
