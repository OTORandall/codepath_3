<?php

  function h($string="") {
    return htmlspecialchars($string);
  }

  function u($string="") {
    return urlencode($string);
  }

  function raw_u($string="") {
    return rawurlencode($string);
  }

  function redirect_to($location) {
    header("Location: " . $location);
    exit;
  }

  function url_for($script_path) {
    return DOC_ROOT . $script_path;
  }

  function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }

  function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
  }

  function request_is_same_domain() {
    if(!isset($_SERVER['HTTP_REFERER'])) { return false; }
    $referer_host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    return ($referer_host === $_SERVER['HTTP_HOST']);
  }

  function display_errors($errors=array()) {
    $output = '';
    if (!empty($errors)) {
      $output .= "<div class=\"errors\">";
      $output .= "Please fix the following errors:";
      $output .= "<ul>";
      foreach ($errors as $error) {
        $output .= "<li>{$error}</li>";
      }
      $output .= "</ul>";
      $output .= "</div>";
    }
    return $output;
  }

  function encrypt($string=''){
    $CIPHER_METHOD = 'AES-256-CBC';
    $key = "a8b8c8d8";
    $key = str_pad($key, 32, '*');
    $iv_length = openssl_cipher_iv_length($CIPHER_METHOD);
    $iv = openssl_random_pseudo_bytes($iv_length);
    $encrypted = openssl_encrypt($string, $CIPHER_METHOD, $key, OPENSSL_RAW_DATA, $iv);
    $result = $iv . $encrypted;
    return base64_encode($result);
  }

  function decrypt($string=''){
    $CIPHER_METHOD = 'AES-256-CBC';
    $key = "a8b8c8d8";
    $key = str_pad($key, 32, '*');
    $iv_with_ciphertext = base64_decode($string);
    $iv_length = openssl_cipher_iv_length($CIPHER_METHOD);
    $iv = substr($iv_with_ciphertext, 0, $iv_length);
    $ciphertext = substr($iv_with_ciphertext, $iv_length);
    $string = openssl_decrypt($ciphertext, $CIPHER_METHOD, $key, OPENSSL_RAW_DATA, $iv);
    return $string;
  }

  function sign_hash($string){
    $salt = "yecp965zy4";
    return hash('sha256', $string . $salt);
  }
  function sign($string){
     $signature = sign_hash($string);
     return $string . '--' . $signature;
  }

  function signed_string_is_valid($signed_string){
    $array = explode('--', $signed_string);
    if(count($array) != 2) { return false; }
    $new_signed = sign_hash($array[0]);
    return ($new_signed === $array[1]);
  }

?>
