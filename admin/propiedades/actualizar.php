<?php

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

require '../../includes/app.php';
    authenticado();

//conseguir url del id y validar que sea un numero
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location: /admin');
}

$propiedad = Propiedad::find($id);

$vendedores = Vendedor::all();

//Arreglo con mensajes de errores
$errores = Propiedad::getErrores();

//Ejecutar el codigo despues de verificar formulario
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    //Asignar los atributos
    $args = $_POST['propiedad'];
    
    $propiedad->sincronizar($args);

    //Validacion de subida de archivos
    $errores = $propiedad->validar();

    //Realiza un resize con Intervention

    //Generar nombre unico para cada imagen
    $nombreImagen= md5( uniqid(rand(), true)) . ".jpg";

    if($_FILES['propiedad']['tmp_name']['imagen']){
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
        $propiedad->setImagen($nombreImagen);
    }

    //Revisar el arreglo de errores esté vacío
    if(empty($errores)){
        if($_FILES['propiedad']['tmp_name']['imagen']){
            //Almacenar imagenes
            $image->save(CARPETA_IMAGENES . $nombreImagen);
        }
        $propiedad->guardar();
    }

}

incluirTemplate('header', $inicio = false);

?>

    <main class="contenedor seccion">
        <h1>Actualizar</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        
            <?php foreach ($errores as $error): ?>
                <div class="alerta error">
                <?php echo $error;?>
                </div>
            <?php endforeach; ?>
        

        <form class="formulario" method="POST" enctype="multipart/form-data">

            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

    <?php incluirTemplate('footer'); ?>