<?php 

    require 'includes/config/database.php';
    $db = conectarDB();

    $errores =[]; 
    //Autenticar usuario
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        // var_dump($_POST);

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ;
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!$email){
            $errores[]= 'El email es obligatorio o no es válido';
        }

        if(!$password){
            $errores[]= 'El Password es obligatorio';
        }

        if (empty($errores)){
            //Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '${email}' ";
            $resultado = mysqli_query($db, $query);

            if ($resultado->num_rows){
                //Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                //Verificar si el password es correcto o no
                $auth = password_verify($password, $usuario['password']);

                if ($auth){
                    //Guardar el usuario ha sido autenticado
                    session_start();

                    //Agregar dato a la session

                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');
                    // var_dump($_SESSION);
                } else{
                    $errores[] = 'El password es incorrecto';
                }
            } else{
                $errores[]= 'El usuario no existe';
            }
        }
    }

    //Incluye el header
    require 'includes/funciones.php';

    incluirTemplate('header', $inicio = false);

?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario"novalidate>
        <fieldset>
                <legend>Email y Password</legend>
                <label for="email">Tu E-Mail</label>
                <input id="email" name="email" type="email" placeholder="Tu email" required>

                <label for="password">Tu Password</label>
                <input id="password" name="password" type="password" placeholder="Tu password" required>
            </fieldset><!-- Información personal -->

            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>
    </main>

    <?php incluirTemplate('footer'); ?>