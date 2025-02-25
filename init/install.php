<?php

/*
  author: krutik
*/

  include_once("./config.app.php");

  // Set variables for our request
  $shop = $_GET['shop'];
  $api_key = API_KEY;

  $redirect_uri = BASE_URL."/init/generate_token.php";

  // Build install/approval URL to redirect to
  $install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . ACCESS_SCOPES . "&redirect_uri=" . urlencode($redirect_uri);

  // Redirect
  header("Location: " . $install_url);
  die();

?>