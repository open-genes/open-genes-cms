<?php
namespace genes\helpers;

class LanguageMapHelper
{
    public function getMappedLanguage($language)
    {
        if(strtolower($language) === 'en') {
            $language = 'en-US';
        }
        if(strtolower($language) === 'ru') {
            $language = 'ru-RU';
        }

        return $language;
    }
}