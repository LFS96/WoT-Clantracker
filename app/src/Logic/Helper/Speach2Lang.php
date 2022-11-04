<?php

namespace App\Logic\Helper;

use Cake\ORM\TableRegistry;

class Speach2Lang
{
    public static function getLang($text)
    {
        if($text == null){
            return null;
        }
        $langDetector = new \LanguageDetector\LanguageDetector();
        $detectedLanguage = $langDetector->evaluate($text)->getLanguage();

        switch ($detectedLanguage){
            case 'da':
                $detectedLanguage = "dk";break;
            case 'sw':
                $detectedLanguage = "tz";break;
            case 'el':
                $detectedLanguage = "gr";break;
            case 'sq':
                $detectedLanguage = "al";break;
            case 'i-klingon':
                $detectedLanguage = "kl";break;
            case 'uk':
                $detectedLanguage = "ua";break;
            case 'fa':
                $detectedLanguage = "ir";break;
            case 'he':
                $detectedLanguage = "il";break;
            case 'zh-cn':
                $detectedLanguage = "cn";break;
        }

        $lang = TableRegistry::getTableLocator()->get('Langs')->find('all')->where(['iso2' => $detectedLanguage])->first();
        if ($lang) {
            return $lang;
        } else {

            return $detectedLanguage;
        }
    }

}
