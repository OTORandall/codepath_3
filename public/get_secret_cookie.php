<?php
require_once('../private/initialize.php');?>

<?php
$scrt = $_COOKIE['scrt'];
if(signed_string_is_valid($scrt)){
  // need to decript it and then get the original message
  $array = explode('--', $scrt);
  $scrt = $array[0];
  $scrt = decrypt($scrt);
  echo " The secret is: " . $scrt;

}
else{
  echo " Error: Not valid sign ";
  exit;
}
 ?>
