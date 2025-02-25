<?php

/*
	author: krutik
*/

include_once("config.app.php");
include_once('../vendor/autoload.php');

use Lib\MySQL;

// Set variables for our request
$api_key = API_KEY;
$shared_secret = API_SECRET;
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically

$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {

	// Set variables for our request
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);

	// Generate access token URL
	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

	// Configure curl client and execute request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);

	// Store the access token
	$result = json_decode($result, true);
	$access_token = $result['access_token'];

	$checkshopquery = "SELECT id FROM stores WHERE host = ? ";
	$bindParams = [$params['host']];
	$checkshop = MySQL::select($checkshopquery, $bindParams, 's');

	if (count($checkshop) > 0){
		$updatetokenquery = "UPDATE stores SET token = ?, disflag = ? WHERE host = ? ";
		$bindParams = [$access_token, 0, $params['host']];
		$updatetoken = MySQL::edit($updatetokenquery, $bindParams, 'sis');

		if ($updatetoken){
			header("Location: https://". $params['shop'] . APP_ADMIN_PATH);
			exit();
		}else{
			echo "Something went wrong! Please try again.";
		}
	}else{

		$inserttokenquery = "INSERT INTO stores(store_name, host, token, disflag) VALUES (?, ?, ?, ?)";
		$bindParams = [$params['shop'], $params['host'], $access_token, 0];
		$inserttoken = MySQL::insert($inserttokenquery, $bindParams, 'sssi');

		if ($inserttoken){
			header("Location: https://". $params['shop'] . APP_ADMIN_PATH);
			exit();
		}else{
			echo "Something went wrong! Please try again.";
		}
	}

} else {
	// Someone is trying to be shady!
	die('This request is NOT from Shopify!');
}