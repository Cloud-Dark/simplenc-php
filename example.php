<?php
include "./helper.php";
$enctext = encrypt_decrypt("encrypt", "Yot plain text in here");
echo $enctext;
$dectext = encrypt_decrypt("decrypt", $enctext);
echo $dectext;
