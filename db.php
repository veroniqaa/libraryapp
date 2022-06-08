<?php

$host = '';
$db = 'library';
$username = '';
$password = '';

$conn = new mysqli($host, $username, $password, $db);

if($conn->connect_errno) {
    echo $conn->connect_error;
    exit();
} 