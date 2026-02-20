<?php 

    require_once("templates/header.php");

?>

<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['usuario']) && !empty($_POST['contra'])){
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contra'];
        if($usuario == 'admin' && $contraseña == '1234'){
            $_SESSION['admin'] = $usuario;
            header("Location: inicio.php");
            exit();
        } else{
            echo "Credenciales Incorrectas, intentelo de nuevo";
            exit();
        }
    }else{
        echo "Has dejado campos vacios";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="formLogin">
        <form action="login.php" method="post">
            <label>Usuario</label><br>
            <input type="text" name="usuario"><br>
            <label>Contraseña</label><br>
            <input type="password" name="contra"><br>
            <input type="submit" id="botonEnviar" name="enviar" value="Iniciar Sesion">
            <input type="button" id="botonCancelar" name="cancelar" value="Cancelar">
        </form>
    </div>
    
</body>
</html>

<?php 

    require_once("templates/footer.php");

?>