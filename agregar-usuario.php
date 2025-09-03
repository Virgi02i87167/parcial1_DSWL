<?php
session_start();
if(isset($_SESSION['usuario'])== null){
    Header('Location: index.php');
}
include_once('./conf/conf.php');
$nombre=isset($_POST['usuario']) ? $_POST['usuario']:"";
$usuario=isset($_POST['correo']) ? $_POST['correo']:"";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Agregar Usuario</title>
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
        <input type="text" name="usuario" id="usuario" class="form-control" required placeholder="Ingrese su nombre de usuario" value="<?php echo $nombre ?>">

        <label for="correo" class="form-label">Correo</label>
        <input type="email" name="correo" id="correo" class="form-control" required placeholder="Ingrese su correo valido" value="<?php echo $usuario ?>">
    
        <label for="pwd" class="form-label">Contraseña</label>
        <input type="password" name="pwd" id="pwd" class="form-control" required placeholder="*********">
        <br>
        <input type="submit" class="form-control btn btn-primary" value="Registrar">
    </form>
</div>
</body>
</html>
<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $nombre=isset($_POST['usuario']) ? $_POST['usuario']:"";
    $usuario=isset($_POST['correo']) ? $_POST['correo']:"";
    $pwd=isset($_POST['pwd']) ? $_POST['pwd']:"";
    $passformat=MD5($pwd);

    $vericar_nombre="SELECT * from usuario WHERE usuario='$nombre'";
    $verificar_sql= mysqli_query($con, $vericar_nombre);
    if(mysqli_num_rows($verificar_sql)>=1){
        echo "<script>alert('El nombre de usuario ya existe pruebe con otro')</script>";
    }else {
        $insertar= "INSERT INTO usuario (id, usuario, email,pwd) VALUES 
        (NULL, '$nombre', '$usuario','$passformat')";
        $ejecucion= mysqli_query($con, $insertar);
            if($ejecucion){
            header('Location: usuarios.php');
            }else{
            header('Location: agregar-usuario.php');
            }
    }

}
?>