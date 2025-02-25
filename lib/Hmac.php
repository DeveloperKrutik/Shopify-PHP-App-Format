<?php

/*
  author: krutik
*/

namespace Lib;

class Hmac {

    public static function validate($params){
        $hmac = $params['hmac'] ?? '';
        $params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
        ksort($params);
        $calculated_hmac = hash_hmac('sha256', http_build_query($params), API_SECRET);

        return hash_equals($hmac, $calculated_hmac);
    }

    public static function encode($params, $encode_url = false){
        ksort($params);
        $hmac = hash_hmac('sha256', http_build_query($params), API_SECRET);
        $params['hmac'] = $hmac;
        // Utility::printR($params);
        return $encode_url ? http_build_query($params) : $params;
    }
}

?>