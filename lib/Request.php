<?php

/*
  author: krutik
*/

namespace Lib;

class Request {

    public static function validate_and_fetch($params, $is_ajax = false){
        $return = null;

        if(Hmac::validate($params)){
            $host = $params['host'] ?: null;
            $shopquery = "SELECT id, token, store_name FROM stores WHERE host = ? AND disflag = ? ";
            $bindParams = [ $host, 0 ];
            $shopdata = MySQL::select($shopquery, $bindParams, 'si');

            if(count($shopdata) > 0){
                $params['store_id'] = $shopdata[0]['id'];
                $params['token'] = $shopdata[0]['token'];
                $params['store_name'] = $shopdata[0]['store_name'];
                $return = $params;
            }
        }
        
        if(!$return && !$is_ajax) Utility::printR(Constants\Messages::REQUEST_TAMPER_MSG);
        
        return $return;
    }
}

?>