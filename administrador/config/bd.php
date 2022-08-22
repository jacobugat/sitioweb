<?php
$host="localhost";
$db="sitio";
$usuario="root";
$contrasenia="";

// validar conexion
try {
    $conexion=new PDO("mysql:host=$host;dbname=$db", $usuario, $contrasenia);
    if ($conexion) {
        //echo "Conectado... a sistema";
    }
} catch ( Exception $ex ) {
    echo $ex->getMessage;
}
?>