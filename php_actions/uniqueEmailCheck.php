<?php
require_once 'db_connect.php';

$email = $_POST["email"];

$sql = "Select * from cr11_vedrana_petadoption.users where useremail like '$email'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows != 0) {
    echo "&#x2717; Sorry, This email address is already in use, please choose another one.";
}