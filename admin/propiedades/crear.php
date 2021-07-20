<?php 

    require '../../includes/app.php';

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;
    
    authenticado();

    $propiedad = new Propiedad;

    //Importar vendedores
    $vendedores = Vendedor::all();

    
    //Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

//Ejecutar el codigo despues de verificar formulario
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //Crea nueva instancia
    $propiedad = new Propiedad($_POST['propiedad']);
        //Generar nombre unico para cada imagen

        $nombreImagen= md5( uniqid(rand(), true)) . ".jpg";

        //Realiza un resize con Intervention
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }


    $errores = $propiedad->validar();

    if(empty($errores)){

        
        //Crear carpeta de imagen
        if(!is_dir(CARPETA_IMAGENES)){
            mkdir(CARPETA_IMAGENES);
        }
        
        
        //Guardar la imagen en el servidor
        $image->save(CARPETA_IMAGENES . $nombreImagen);
        
        $propiedad->guardar();


    }

    // debug($propiedad->crear());

}


incluirTemplate('header', $inicio = false);

?>

    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        
            <?php foreach ($errores as $error): ?>
                <div class="alerta error">
                <?php echo $error;?>
                </div>
            <?php endforeach; ?>
        

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">

            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

    <?php incluirTemplate('footer'); ?>