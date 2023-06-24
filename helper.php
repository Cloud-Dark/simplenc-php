<?php
function encrypt_decrypt($action, $string) {
  $output = false;
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'xxxxxxxxxxxxxxxxxxxxxxxx';
  $secret_iv = 'xxxxxxxxxxxxxxxxxxxxxxxxx';
  
  // Hash the secret key with a unique salt
  $salt = "some_random_salt";
  $key = hash('sha256', $salt . $secret_key);    
  
  // Create an initialization vector
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
  
  if ( $action == 'encrypt' ) {
    // Encrypt the string
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    
    // Base64 encode the output to make it unreadable
    $output = base64_encode($output);
    
    // Add a checksum to the end of the encrypted string
    $checksum = md5($output . $secret_key);
    $output .= $checksum;
  } 
  else if( $action == 'decrypt' ) {
    // Check if the encrypted string has a valid checksum
    $checksum = substr($string, -32);
    $string = substr($string, 0, -32);
    if(md5($string . $secret_key) != $checksum) {
        return false;
    }
    
    // Decrypt the string
    // First, we need to decode the base64 string to get the encrypted message
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }
  
  return $output;
}
