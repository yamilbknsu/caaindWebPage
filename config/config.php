<?php
echo gethostbyname ( "www2.udec.cl" );
/* Database credentials*/
define('DB_SERVER', '152.74.16.10');
define('DB_USERNAME', 'caaind');
define('DB_PASSWORD', '#caaind2019');
define('DB_NAME', 'caaind');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect("152.74.16.10", DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
echo "Success";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
</body>
</html>