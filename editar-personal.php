<?php
session_start();
if(isset($_SESSION['usuario'])== null){
    Header('Location: index.php');
}
include_once('./conf/conf.php');
$id=isset($_GET['id']) ? $_GET['id']:"";
$seleccion="SELECT nombre, telefono, dui, fecha_nacimiento, departamento, distrito, colonia, calle, casa, imagen from personal where id=$id";
$ejecutar = mysqli_query($con, $seleccion);
$datos = mysqli_fetch_assoc($ejecutar);

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $nombre = isset($_POST['nombre']) ? $_POST['nombre']:""; 
    $telefono= isset($_POST['telefono']) ? $_POST['telefono']:""; 
    $dui = isset($_POST['dui']) ? $_POST['dui']:""; 
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento']:""; 
    $departamento = isset($_POST['departamento']) ? $_POST['departamento']:""; 
    $distrito = isset($_POST['distrito']) ? $_POST['distrito']:""; 
    $colonia = isset($_POST['colonia']) ? $_POST['colonia']:""; 
    $calle = isset($_POST['calle']) ? $_POST['calle']:""; 
    $casa = isset($_POST['casa']) ? $_POST['casa']:""; 
    $imagen_actual = $_POST['imagen_actual'] ?? "";

    // MANEJO DE IMAGEN NUEVA
    $rutaImagen = $imagen_actual; // por defecto se queda la vieja
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $directorio = "uploads/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }
        $rutaImagen = $directorio . time() . "_" . basename($_FILES["imagen"]["name"]);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImagen);
    }

    $estado_dui = "SELECT dui from personal where id=$id";
    $verificar_sql = mysqli_query($con, $estado_dui);
    $verficador = mysqli_fetch_assoc($verificar_sql);
    $var_dui = $verficador['dui'];

    if($var_dui == $dui){
        $update_personal = "UPDATE personal set nombre='$nombre', telefono='$telefono', dui='$dui', fecha_nacimiento='$fecha_nacimiento', departamento='$departamento',
        distrito='$distrito', colonia='$colonia', calle='$calle', casa='$casa', imagen='$rutaImagen' where id=$id";
        $update_ejecucion = mysqli_query($con, $update_personal);
        if($update_ejecucion){
            header('Location: personal.php');
        }
    }else {
        $verificar_nuevo = "SELECT dui from personal where dui = '$dui'";
        $exec_Verificacion = mysqli_query($con, $verificar_nuevo);
        if(mysqli_num_rows($exec_Verificacion) >= 1){
            echo "<script>alert('El numero de DUI ya existe pruebe con otro')</script>";
        }else{
            $update_usuario = "UPDATE personal set nombre='$nombre', telefono='$telefono', dui='$dui', fecha_nacimiento='$fecha_nacimiento', departamento='$departamento',
            distrito='$distrito', colonia='$colonia', calle='$calle', casa='$casa', imagen='$rutaImagen' where id=$id";
            $update_ejecucion = mysqli_query($con, $update_personal);;
            $update_ejecucion = mysqli_query($con, $update_personal);
            if($update_ejecucion){
                header('Location: personal.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Editar Personal</title>
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
        <form action="" method="POST" class="form-control" enctype="multipart/form-data">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required placeholder="Ingrese su nombre completo" value="<?php echo $datos['nombre'] ?>">
            <br>
            <label for="telefono" class="form-label">Telefono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" required placeholder="Ingrese su noumero de telefono" value="<?php echo $datos['telefono']?>">
            <br>
            <label for="dui" class="form-label">Dui</label>
            <input type="text" name="dui" id="dui" class="form-control" required placeholder="Ingrese su DUI" value="<?php echo $datos['dui'] ?>">
            <br>
            <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required placeholder="Ingrese su fecha de nacimiento" value="<?php echo $datos['fecha_nacimiento'] ?>">
            <br>
            <label for="departamento" class="form-label">Departamento</label>
            <input type="text" name="departamento" id="departamento" class="form-control" required placeholder="Ingrese Departamento" value="<?php echo $datos['departamento'] ?>">
            <br>
            <label for="distrito" class="form-label">Distrito</label>
            <input type="text" name="distrito" id="distrito" class="form-control" required placeholder="Ingrese el distrito" value="<?php echo $datos['distrito'] ?>">
            <br>
            <fieldset>
                <legend>Dirección</legend>

                <label for="colonia" class="form-label">Colonia:</label>
                <input type="text" id="colonia" name="colonia" id="colonia" class="form-control" required placeholder="Ingrese el nombre de la colonia" value="<?php echo $datos['colonia'] ?>">

                <label for="calle" class="form-label">Calle/Polígono:</label>
                <input type="text" id="calle" name="calle" id="calle" class="form-control" required placeholder="Ingrese la calle/poligono" value="<?php echo $datos['calle'] ?>">

                <label for="casa" class="form-label">Casa/Apartamento:</label>
                <input type="text" id="casa" name="casa" id="casa" class="form-control" required placeholder="Ingrese casa/apartamento" value="<?php echo $datos['casa'] ?>">
            </fieldset>
            <br>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen actual:</label><br>
                <img src="<?php echo $datos['imagen']; ?>" alt="Imagen actual" width="120" class="mb-2 border rounded">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Selecciona una nueva imagen (opcional):</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" class="form-control">
            </div>

            <input type="hidden" name="imagen_actual" value="<?php echo $datos['imagen']; ?>">
            <br>
            <input type="submit" class="form-control btn btn-primary" value="Actualizar">
        </form>
    </div>
</body>
</html>