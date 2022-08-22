<?php
session_start();
if(!isset($_SESSION['usuario'])){
  header("Location:../index.php");
}else{
  if($_SESSION['usuario']=="ok"){
    $nombreUsuario=$_SESSION['nombreUsuario'];
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <style>
@media only screen and (max-width: 600px) {
    #no-more-tables tbody, 
    #no-more-tables tr, 
    #no-more-tables td {
      display: block;
    }
    #no-more-tables thead tr {
      position: absolute;
      top: -9999px;
      left: -9999px;
      border-bottom: 2px solid #eee;
    }
    #no-more-tables td {
      position: relative;
      padding-left: 43%;
      height: 78px;
      display: flex;
      align-items: center;
      border: 1px solid #EDEFF1;
    }
    #no-more-tables td:before{
      content: attr(data-title);
      position: absolute;
      left: 15px;
      font-weight: bold;
    }
    #no-more-tables tr {
      border-bottom: 1px solid #ccc;
      height: 330px;
    }
    #no-more-tables .ac {
      display: flex;
      flex-direction: column;
    }
    .ac input {
      font-size:12px;
      width: 120px;
      margin:3px;
    }
}
</style>
    <title>Lorem, ipsum.</title>
</head>
<body>
<?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb" ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Administrador</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo $url;?>/administrador/inicio.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url;?>/administrador/seccion/productos.php">crud</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url;?>">Ver web</a>
        </li>
      </ul>
      <ul class="navbar-nav d-flex">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $url;?>/administrador/seccion/cerrar.php"administrador/index.php">Cerrar</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <div class="container">
    <br><br>
       <div class="row">