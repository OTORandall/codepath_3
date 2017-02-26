<?php
require_once('../private/initialize.php');?>

<?php
$secret = "I have a secret to tell";
$encrypted_s = encrypt($secret);
setcookie('scrt', sign($encrypted_s));
?>
