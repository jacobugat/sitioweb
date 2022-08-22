<?php include("../template/cabecera.php"); ?>
<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");

switch($accion){
    case "Agregar":
        $sentenciaSQL=$conexion->prepare("INSERT INTO libros (nombre,imagen) VALUES (:nombre,:imagen);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $fecha=new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        $tmpImagen=$_FILES['txtImagen']['tmp_name'];
        if($tmpImagen!="") {
            move_uploaded_file($tmpImagen,'../../img/'.$nombreArchivo);
        }        
        $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        break;
    case "Modificar":
        // nombre
        $sentenciaSQL= $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        // imagen
        if($txtImagen!="") {

            $fecha=new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES['txtImagen']['tmp_name'];
            move_uploaded_file($tmpImagen,'../../img/'.$nombreArchivo);
            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            if(isset($libro["imagen"])&&($libro["imagen"]!="imagen.jpg")) { // nombre de la imagen del libro: $libro["imagen"
                if(file_exists("../../img/".$libro["imagen"])){
                    unlink("../../img/".$libro["imagen"]); // esta linea borra el archivo
                }
            }

            //////
            $sentenciaSQL= $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
        }
        header("Location:productos.php");
        break;
    case "Cancelar":
        header("Location:productos.php");
        break;        
    case "Seleccionar":
        $sentenciaSQL= $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        $txtNombre=$libro['nombre'];
        $txtImagen=$libro['imagen'];
        break;
    case "Borrar":
        $sentenciaSQL= $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if(isset($libro["imagen"])&&($libro["imagen"]!="imagen.jpg")) { // nombre de la imagen del libro: $libro["imagen"
            if(file_exists("../../img/".$libro["imagen"])){
                unlink("../../img/".$libro["imagen"]); // esta linea borra el archivo
            }
        }
        $sentenciaSQL= $conexion->prepare("DELETE FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        break;        
}

$sentenciaSQL= $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Formulario
        </div>
        <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class = "form-group">
                <label for="txtID">ID:</label>
                <input required readonly type="text" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
            </div>

            <div class = "form-group">
                <label for="txtNombre">Nombre:</label>
                <input type="text" class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del proyecto" required>
            </div>

            <div class = "form-group">
                <label for="txtImagen">Imagen:</label>
                <br>
                <?php if ($txtImagen!="") { ?>
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="180" style="margin-bottom:10px;">
                <?php } ?>
                <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen">
            </div>
            <br>
            <div class="d-grid gap-2 col-12 mx-">
                <button class="btn btn-primary" type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar">Agregar</button>
                <button class="btn btn-primary" type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar">Modificar</button>
                <button class="btn btn-primary" type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar">Cancelar</button>
            </div>
        </form>            
    </div>
</div>
</div>

<div class="col-md-7 table-responsive">    
<table class="table table-bordered" id="no-more-tables">
        <thead>
            <tr>
                <th class="text-start" scope="col">ID</th>
                <th class="text-start" scope="col">Nombre</th>
                <th class="text-start" scope="col">Imagen</th>
                <th class="text-start" scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaLibros as $libro) { ?>
            <tr>
                <td class="text-start" data-title="ID"><?php echo $libro["id"]; ?></td>
                <td class="text-start" data-title="Nombre"><?php echo $libro["nombre"]; ?></td>
                <td class="text-start" data-title="Imagen">
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $libro["imagen"]; ?>" width="50" alt="">
                </td>
                <td class="text-start" data-title="Acciones">
                    <form method="post" class="ac">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro["id"]; ?>"/>
                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include("../template/pie.php"); ?>