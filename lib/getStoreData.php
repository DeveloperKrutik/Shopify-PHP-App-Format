<?php

namespace Lib;

class getStoreData {
  public static function get($store = "") {
    $shopquery = "SELECT id, token FROM stores WHERE store_name = ? ";
  	$shopdata = MySQL::select($shopquery, [$store], 's');

    return count($shopdata) ? $shopdata : null;
  }
}

?>