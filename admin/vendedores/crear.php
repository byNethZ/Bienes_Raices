<?php

    require '../../includes/app.php';

    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    authenticado();

    $vendedor = new Vendedor;

    //Arreglo con mensajes de errores
    $errores = Vendedor::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $vendedor = new Vendedor($_POST['vendedor']);

        //Intervention para la imagen de Perfil
        $nombreImagen= md5( uniqid(rand(), true)) . ".jpg";
        //Realiza un resize con Intervention
        // debug($_FILES['vendedor']['tmp_name']);
        if($_FILES['vendedor']['tmp_name']['imagen']){
            $image = Image::make($_FILES['vendedor']['tmp_name']['imagen'])->fit(800,600);
            $vendedor->setImagen($nombreImagen);
        }

        $errores= $vendedor->validar();

        if(empty($errores)){

            //Crear carpeta de imagen
            if(!is_dir(CARPETA_PERFILES)){
                mkdir(CARPETA_PERFILES);
            }
            //Guardar la imagen en el servidor
            $image->save(CARPETA_PERFILES . $nombreImagen);

            $vendedor->guardar();
        }

    }

    incluirTemplate('header', $inicio = false);

?>

<main class="contenedor seccion">
    <h1>Registrar Vendedo(a)</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>

    
        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
            <?php echo $error;?>
            </div>
        <?php endforeach; ?>
    

    <form class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer'); ?>