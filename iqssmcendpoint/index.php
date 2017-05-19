
<?php
#*************************
# Using Discovery IP based lookup to confirm if a network is from a correct operator.
# If there is no operator detected the code will send the user to the 302 error url on the href response to get the msisdn and redo discovery.
# Running this in the backend before offering Mobile Connect Options to the user.
# if discovery resoinse returns true, you can follow up with the mobile connect request.
# optional to pass the source client IP as ?ip=xxx.xxx.xxx.xxx if you wish. else it will auto get the client's IP
# session_id is passed back so that if we invoke mobile connect next, we nolonger need to re-discover the operator.
#************************
session_start();
//header('Content-Type: application/json');
include "mobileConnect.php";

$mc = new mobileConnect($config);

#$ip = "106.222.81.82";
$ip = "";
if (isset($_GET["ip"])) {
   $ip = $_GET["ip"];
}
$response = $mc->PerformIPDiscovery($ip);

if (isset($response->response->serving_operator)) {
  $_SESSION['disc_response'] = $response;
  $_SESSION['type'] = 0;
  //To be replaced with android module that will fetch the device's ip address at a later time

  //echo json_encode(Array("status"=>true, "session_id"=>session_id()), JSON_PRETTY_PRINT);
  header("Location: start_mc.php?session_id=" . session_id());

} else {
  //   print_r($response);
     if(isset($response->links[0]->href))
     {
       $_SESSION['type'] = 1;
       header("Location: " . $response->links[0]->href);
     }
     else {
       echo "didnt get sh*t";
       echo json_encode(Array("status"=>false), JSON_PRETTY_PRINT);
     }
}
?>
