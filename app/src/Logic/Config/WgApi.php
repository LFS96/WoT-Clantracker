<?php
namespace App\Logic\Config;

use Cake\Core\Configure;
use Wargaming\Api;
use Wargaming\Language\DE;
use Wargaming\Server\EU;

class WgApi
{
    public static function getWG_API (){
        $lang = new DE();
        $server = new EU();
        $key = Configure::read("wot_api_key");
        $server->setApplicationId($key);
        $api = new Api($lang, $server);

        $api->setSSLVerification(false);
        return $api;
    }
}
