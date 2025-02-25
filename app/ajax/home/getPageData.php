<?php

  // Set header to allow cross-origin requests (CORS)
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: Content-Type");

  use Lib\GraphQL;
  use Lib\MySQL;
  use Lib\Request;
  use Lib\Constants\Messages;

  // If it is not a form data, then these two lines are steps how we can handle the data
  $input = file_get_contents('php://input');
  $data = json_decode($input, true);
  
  // request validation
  $params = [
    'host' => $data['host'] ?? false,
    'hmac' => $data['hmac'] ?? false,
  ];
  $request = Request::validate_and_fetch($params, true);

  if(!$request){
    $response = [
      'status' => 'error',
      'type' => 'request',
      'html' => Messages::REQUEST_TAMPER_MSG
    ];
    exit(json_encode($response));
  }

  // Check if the request method is POST
  if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
    ob_start();
?>
        <h5>This data is coming from ajax request...</h5>
<?php
    $html = ob_get_clean();

      $response = [
        'status' => 'success',
        'html' => $html
      ];

      // Set the response header to JSON
      header('Content-Type: application/json');

      // Encode the response array as JSON and send it back to the client
      echo json_encode($response);
  } else {
      // Handle incorrect request method
      echo json_encode([
          'status' => 'error',
          'message' => 'Required fields are missing!',
      ]);
  }
?>