<?php
session_start();
if(isset($_SESSION['usuario'])== null){
    Header('Location: index.php');
}
include_once('./conf/conf.php');
$id=isset($_GET['id']) ? $_GET['id']:"";
$seleccion="SELECT usuario, email from usuario where id=$id";
$ejecutar = mysqli_query($con, $seleccion);
$datos = mysqli_fetch_assoc($ejecutar);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Editar Usuario</title>
    <style>
        .contenido{
            margin:40px;
        }
    </style>
</head>
<body>
    <?php
        include_once('nav.php')
    ?>
    <div class="contenido">
        <form action="" method="POST" class="form-control">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" name="usuario" id="usuario" class="form-control" required placeholder="Ingrese su nombre de usuario" value="<?php echo $datos['usuario'] ?>">

        <label for="correo" class="form-label">Correo</label>
        <input type="email" name="correo" id="correo" class="form-control" required placeholder="Ingrese su correo valido" value="<?php echo $datos['email'] ?>">
    
        <br>
        <input type="submit" class="form-control btn btn-primary" value="Actualizar">
        </form>
    </div>
</body>
</html>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $nombre=isset($_POST['usuario']) ? $_POST['usuario']:"";
    $usuario=isset($_POST['correo']) ? $_POST['correo']:"";
    
    $estado_nombre = "SELECT usuario from usuario where id=$id";
    $verificar_sql = mysqli_query($con, $estado_nombre);
    $verficador = mysqli_fetch_assoc($verificar_sql);
    $var_usuario = $verficador['usuario'];

    if($var_usuario == $nombre){
        $update_usuario = "UPDATE usuario set usuario ='$nombre', email='$usuario' where id=$id";
        $update_ejecucion = mysqli_query($con, $update_usuario);
        if($update_ejecucion){
            header('Location: usuario.php');
        }
    }else {
        $verificar_nuevo = "SELECT usuario from usuario where usuario = '$nombre'";
        $exec_Verificacion = mysqli_query($con, $verificar_nuevo);
        if(mysqli_num_rows($exec_Verificacion) >= 1){
            echo "<script>alert('El nombre de usuario ya existe pruebe con otro')</script>";
        }else{
            $update_usuario = "UPDATE usuario set usuario = '$nombre', email= '$usuario' where id=$id";
            $update_ejecucion = mysqli_query($con, $update_usuario);
            if($update_ejecucion){
                header('Location: usuario.php');
            }
        }
    }
}
?>