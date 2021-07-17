<?php 

    require '../../includes/funciones.php';
    $auth = authenticado();

    if(!$auth){
        header('Location: /');
    }

//conseguir url del id y validar que sea un numero
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location: /admin');
}

//Base de datos
require '../../includes/config/database.php';
$db = conectarDB();

//consulta para datos de la propiedad

$consulta = "SELECT * FROM propiedades WHERE id = ${id}";
$resultado = mysqli_query($db, $consulta);

//se asigna el resultado en la variable propiedad
$propiedad = mysqli_fetch_assoc($resultado);

//Consultar para obtener vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores

$errores = [];

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedorId = $propiedad['vendedorId'];
$imagenPropiedad = $propiedad['imagen'];

//Ejecutar el codigo despues de verificar formulario
if($_SERVER['REQUEST_METHOD'] === 'POST'){
/*     echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    echo '<pre>';
    var_dump($_FILES);
    echo '</pre>'; */

    
    $titulo = mysqli_real_escape_string( $db, $_POST['titulo'] );
    $precio = mysqli_real_escape_string( $db, $_POST['precio'] );
    $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
    $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones'] );
    $wc = mysqli_real_escape_string( $db, $_POST['wc'] );
    $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento'] );
    $vendedorId = mysqli_real_escape_string( $db, $_POST['vendedor'] );
    $creado = date('Y/m/d');

    //Asignar files hacia una variable

    $imagen = $_FILES['imagen'];

    if(!$titulo){
        $errores[]= 'Debes añadir un titulo';
    }

    if(!$precio){
        $errores[]= 'El precio es obligatorio';
    }

    if(strlen($descripcion)<50){
        $errores[]= 'La descripción es obligatoria y debe tener más de 50 carácteres';
    }

    if(!$habitaciones){
        $errores[]= 'El numero de habitaciones es obligatorio';
    }

    if(!$wc){
        $errores[]= 'El numero de wc es obligatorio';
    }

    if(!$estacionamiento){
        $errores[]= 'El numero de plazas de estacionamiento es obligatorio';
    }

    if(!$vendedorId){
        $errores[]= 'Elige un Vendedor';
    }


    //Validar el tamaño de la imagen (1mb max)

    $medida = 1000 * 1000;
    if ($imagen['size'] > $medida){
        $errores[]='La imagen es muy pesada';
    }

/*     echo '<pre>';
    var_dump($errores);
    echo '</pre>'; */

    //Revisar el arreglo de errores esté vacío

    if(empty($errores)){

        //Creación de carpeta
        $carpetaImagenes = '../../imagenes/';

        if(!is_dir($carpetaImagenes)){
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        //Verificar si existe una imagen anterior
        if($imagen['name']){
            //eliminar la imagen previa
            unlink($carpetaImagenes . $propiedad['imagen']);

        //Subida de archivos

        //Generar nombre unico para cada imagen

        $nombreImagen= md5( uniqid(rand(), true)) . ".jpg";

        //subir la image
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
            
        } else{
            $nombreImagen = $propiedad['imagen'];
        }

            //Insertar en Base de Datos

        $query = "UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedorId = ${vendedorId} WHERE id = ${id} ";

        //  echo $query;

        $resultado = mysqli_query($db, $query);

        if($resultado){
            //Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }
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
            <fieldset>
                <legend>Información General de la Propiedad</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo de la Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio de la Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
                <img class="imagen-small" src="/imagenes/<?php echo $imagenPropiedad ?>">

                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>
            <fieldset>
                <legend>Información de la Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" placeholder="Número de habitaciones" min="1" max="9" name="habitaciones" value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" placeholder="Número de baños" min="1" max="9" name="wc" value="<?php echo $wc; ?>">

                <label for="estacionamiento">estacionamiento:</label>
                <input type="number" id="estacionamiento" placeholder="Número de estacionamiento" min="1" max="9" name="estacionamiento" value="<?php echo $estacionamiento; ?>">
            </fieldset>
            <fieldset>
                <legend>Vendedor</legend>
                <select name="vendedor">
                    <option value="">--Seleccione--</option>
                    <?php while ($vendedor = mysqli_fetch_assoc($resultado)): ?>
                        <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"><?php echo $vendedor['nombre'] . " " . $vendedor['apellido'];?></option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

    <?php incluirTemplate('footer'); ?>