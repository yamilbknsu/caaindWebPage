<?php

/* Database credentials*/
$DBHost = "www2.udec.cl";
$DBName = "caaind";
$DBUser = "caaind";
$DBpass = "votacion123";

$mysqli = new mysqli($DBHost, $DBUser, $DBpass, $DBName);

if ($mysqli->connect_errno) {
    // La conexión falló. ¿Que vamos a hacer? 
    // Se podría contactar con uno mismo (¿email?), registrar el error, mostrar una bonita página, etc.
    // No se debe revelar información delicada

    // Probemos esto:
    echo "Lo sentimos, este sitio web está experimentando problemas.";

    // Algo que no se debería de hacer en un sitio público, aunque este ejemplo lo mostrará
    // de todas formas, es imprimir información relacionada con errores de MySQL -- se podría registrar
    echo "Error: Fallo al conectarse a MySQL debido a: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    
    // Podría ser conveniente mostrar algo interesante, aunque nosotros simplemente saldremos
    exit;
}

//$dsn = "mysql:host=".$DBHost.";port=3306;dbname=".$DBName;
/*
try {
    $pdo = new PDO($dsn, $DBUser, $DBpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo $e->getMessage();
    exit('Something weird happened'); //something a user can understand
}
*/
echo "Success";
?>