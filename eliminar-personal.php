<?php
include_once('./conf/conf.php');
    $id=isset($_POST['id']) ? $_POST['id']:"";
    $eliminar="DELETE from personal where id= $id";
    $ejecutar_eliminar= mysqli_query($con, $eliminar);
    if($ejecutar_eliminar){
        header('Location: personal.php');
    }
?>