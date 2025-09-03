<?php
$server="localhost";
$user="root";
$pdw="";
$db="dbrrhh";

$con = new mysqli($server, $user, $pdw, $db);
if($con){
    // echo "conexion exitosa";
}else{
    echo "Ha ocurrido un error de conexcion";
}
?>