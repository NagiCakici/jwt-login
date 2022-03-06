<?php
error_reporting(E_ALL);

$key = "15N2461C2584z";
$issued_at = time();
$expiration_time = $issued_at + (60 * 60); // 1 saat sonrası
$issuer = "http://kodnot.net/jwt-login";