<?php

/*
  author: krutik
*/

namespace Lib;

class GraphQL {

  public static function get($shop, $token, $query){
    $query = json_encode($query);

    $url = "https://".$shop."/admin/api/2024-04/graphql.json";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    if(!is_null($token)) $headers[] = 'X-Shopify-Access-Token: '.$token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_POST, TRUE);

    $result = curl_exec($ch);
    $error_number = curl_errno($ch);
    $error_message = curl_error($ch);

    curl_close($ch);

    if ($error_number) {
      return $error_message;
    } else {

      $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $result, 2);

      $headers = array();
      $header_data = explode("\n",$response[0]);
      $headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
      array_shift($header_data); // Remove status, we've already set it above
      foreach($header_data as $part) {
        $h = explode(":", $part);
        $headers[trim($h[0])] = trim($h[1]);
      }
        return array('headers' => $headers, 'response' => $response[1]);
    }
  }
}

?>