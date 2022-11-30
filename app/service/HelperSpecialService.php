<?php

namespace app\service;


class HelperSpecialService
{
    const SYMBOLS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz-';

    public static function generateUUID($length = 10) {
        $symbols = self::SYMBOLS . strtotime(date("Y-m-d H:i:s"));
        return substr(str_shuffle($symbols), 0, $length);
    }
}