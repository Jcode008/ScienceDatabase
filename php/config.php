<?php 
$host ="br48chr14wfe42z7yirg-mysql.services.clever-cloud.com";
$username="uydxtwygd2yzb0ng";
$password="lM36mTZWw85XKpSLnpr6";   
$database="br48chr14wfe42z7yirg";  


$con = mysqli_connect("$host", "$username", "$password", "$database", "3306");

if (!$con) {

    die("Connection failed: " . mysqli_connect_error());

}




?>