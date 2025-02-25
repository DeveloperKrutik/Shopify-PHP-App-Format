<?php

/*
  author: krutik
*/

namespace Lib;

class Utility {

    public static function printR($params){
        ob_clean();
        echo '<pre>';
        print_r($params);
        echo '</pre>';
        die;
    }
}

?>