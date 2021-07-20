<?php

    require '../../includes/app.php';

    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    authenticado();

    //validar id valido

    $id = $_GET['id'];
    $id= filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /admin');
    }

    //Obtener datos del vendedor
    $vendedor = Vendedor::find($id);

    //Arreglo con mensajes de errores
    $errores = Vendedor::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //Asignar los valores
        $args= $_POST['vendedor'];

        //Sincronizar objeto en memoria con datos del usuario
        $vendedor->sincronizar($args);

        $errores = $vendedor->validar();

        //Imagenes
        if($_FILES['vendedor']['tmp_name']['imagen']){
            $image = Image::make($_FILES['vendedor']['tmp_name']['imagen'])->fit(800,600);
            $vendedor->setImagen($nombreImagen);
        }
    
        //Revisar el arreglo de errores esté vacío
        if(empty($errores)){
            if($_FILES['vendedor']['tmp_name']['imagen']){
                //Almacenar imagenes
                $image->save(CARPETA_PERFILES . $nombreImagen);
            }

            $vendedor->guardar();
        }


    }

    incluirTemplate('header', $inicio = false);

?>

<main class="contenedor seccion">
        <h1>Actualizar Vendedo(a)</h1>
        <a href="/admin" class="boton boton-verde">Volver</a>

        
            <?php foreach ($errores as $error): ?>
                <div class="alerta error">
                <?php echo $error;?>
                </div>
            <?php endforeach; ?>
        

        <form class="formulario" method="POST" action="/admin/vendedores/actualizar.php" enctype="multipart/form-data">

            <?php include '../../includes/templates/formulario_vendedores.php'; ?>

            <input type="submit" value="Guardar Cambios" class="boton boton-verde">
        </form>
    </main>

    <?php incluirTemplate('footer'); ?>