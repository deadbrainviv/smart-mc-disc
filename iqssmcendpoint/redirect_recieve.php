<?php
session_start();
include "mobileConnect.php";

//echo $_SESSION['type'];

$mc = new mobileConnect($config);
$sub_id = 0;
if(isset($_GET['error']))
{
  echo $_GET['error'];
}
if(isset($_SESSION['type']))
{
  // Type 1 request from IP based device.
  if($_SESSION['type'] == 1)
  {
    // Checking if response is a discovery response
    if(isset($_GET['mcc_mnc']))
    {
      echo "Going for Discovery call again <br />";
      $values = explode("_",$_GET['mcc_mnc']);
      echo "MCC= " . $values[0];
      echo " MNC= " . $values[1] . "<br />";

      if($_GET['subscriber_id'])
      {
        $sub_id = $_GET['subscriber_id'];
      }
      else {
        echo "Didnt get subscriber ID response ";
      }

      $response = $mc->PerformGetDiscoverySelectedMCCMNC($values[0],$values[1]);
      // echo "<pre>";
      //   print_r($response);
      // echo "</pre>";
      echo "Going for Authorization Call";
      $parsedisc = false;
      $parsedisc = $mc->parseDiscoveryResponse($response);
      if($parsedisc == true)
      {
        $auth_url = $mc->mobileconnectAuthenticate($sub_id, "openid", 1);
        $_SESSION['mc_obj'] = serialize($mc);
        header("Location:".$auth_url);
    //  echo $ parsedisc;
    //  print_r($mc);
      }
    else {
      echo "The Discovery Response is invalid";
    }
    }
    if(isset($_GET['state']) && isset($_GET['code'])){
      $code = $_GET['code'];
      $state = $_GET['state'];
    //  echo "WE can begin token request";
      $mc = unserialize($_SESSION['mc_obj']);
      $mctoken_array= array("code" => $code, "state"=> $state);
//      echo "Token request completed";
      $mc->callback($mctoken_array);
  //    echo "Parsing response ";

    }
    else
    {
      echo "Cannot proceed further, Didnt get proper auth Response :(";
    }
  }
  else {
    //Impement code for type 2 from mobile network . change the value in mobileconnectAuthenticate function 1 to 2...
    if(isset($_GET['state']) && isset($_GET['code'])){
      $code = $_GET['code'];
      $state = $_GET['state'];
    //  echo "WE can begin token request";
      $mc = unserialize($_SESSION['mc_obj']);
      $mctoken_array= array("code" => $code, "state"=> $state);
//      echo "Token request completed";
      $mc->callback($mctoken_array);
  //    echo "Parsing response ";

    }
  }
}
else {
  echo "Session variable not set, Cannot identify the connection type";
}



 ?>
