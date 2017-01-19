<?php require_once("var_token.inc.php");?>
<?php
function fn_profile($userId){
  global $access_token;
//$url = 'https://api.line.me/v1/profile';
$url="https://api.line.me/v2/bot/profile/".$userId;
$headers = array('Authorization: Bearer ' . $access_token);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
  $arrProfile=json_decode($result,true);
  return $arrProfile;
  //return $result;
  
  /*
  $arrProfile=fn_profile($userId);
  $arrProfile["displayName"];
  $arrProfile["userId"];
  $arrProfile["pictureUrl"];
  $arrProfile["statusMessage"];
  */
  
}
