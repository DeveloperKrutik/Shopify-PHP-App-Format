<?php

  use Lib\Request;
  use Lib\Hmac;

  $request = Request::validate_and_fetch($_GET);

  $urlParams = ['host' => $request['host']];
  $hostHmac = Hmac::encode(array_merge($urlParams));

  ob_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/inc/css/shopify-polaris.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/inc/css/custom.css?v=<?php echo time(); ?>">
    <meta name="shopify-api-key" content="<?php echo API_KEY; ?>" />
    <script src="https://cdn.shopify.com/shopifycloud/app-bridge.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  </head>
  
  <body>

    <h1>Shopify App Demo Format for Core PHP and MySQL based development</h1>
    <div id="ajaxData">

    </div>

    <script>

      document.addEventListener('DOMContentLoaded', (e) => {
        getHomePageData();
      });

      function getHomePageData(){
        var data = {
          host: shopify.config.host,
          hmac: '<?php echo $hostHmac['hmac']; ?>'
        }

        fetch('<?php echo WORKING_DIR; ?>/home/page', {
          method: 'POST',
          body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
          if(data['status'] == 'error'){
            if(data['type'] == 'request') document.getElementById("ajaxData").innerHTML = data['html'];
            shopify.toast.show(data['message'] ?? 'Something went wrong!', { isError: true });
          }else{
            document.getElementById("ajaxData").innerHTML = data['html'];
          }
        })
        .catch(error => {
          shopify.toast.show('Something went wrong!', { isError: true });
          console.log(error);
        });
      }

    </script>

  </body>
</html>