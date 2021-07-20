<?php 

    require '../includes/app.php';
    authenticado();

    //Importar clases
    use App\Propiedad;
    use App\Vendedor;

    //Obtener los resultado con Active Records
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    //los resultados se muestran en el cuerpo html abajo

    //Condicional para el resultado
    $resultado = $_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $id= $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id){

            $tipo = $_POST['tipo'];
            if(validarTipoContenido($tipo)){

                //Compara lo que se va a eliminar
                if($tipo === 'vendedor'){
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar(2);

                }else if($tipo === 'propiedad'){
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar(1);
                }
            }

        }
    }

    //incluye un template


    incluirTemplate('header', $inicio = false);

?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php
            $mensaje = mostrarMensajes(intval($resultado));
            if ($mensaje){ ?>
                <p class="alerta exito"><?php echo s($mensaje); ?></p>
           <?php }?>
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
        <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo(a) Vendedor</a>

        <h2>Propiedades</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los resultados del query y la base de datos -->
                <?php foreach ($propiedades as $propiedad) : ?>                     
                    <tr>
                        <td><?php echo $propiedad->id; ?></td>
                        <td><?php echo $propiedad->titulo; ?></td>
                        <td><img class="imagen-tabla" src="/imagenes/<?php echo $propiedad->imagen ?>"></td>
                        <td>$<?php echo $propiedad->precio; ?></td>
                        <td>
                            <form method="POST" class="w-100">
                                <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                                <input type="hidden" name="tipo" value="propiedad">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>                            
                            <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>                    
                    <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Vendedores</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Perfil</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- Mostrar los resultados del query y la base de datos -->
                <?php foreach ($vendedores as $vendedor) : ?>                     
                    <tr>
                        <td><?php echo $vendedor->id; ?></td>
                        <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                        <td><?php echo $vendedor->telefono; ?></td>
                        <td><img class="imagen-tabla" src="/perfiles/<?php echo $vendedor->imagen ?>"></td>
                        <td>
                            <form method="POST" class="w-100">
                                <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                                <input type="hidden" name="tipo" value="vendedor">
                                <input type="submit" class="boton-rojo-block" value="Eliminar Vendedor">
                            </form>                            
                            <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>                    
                    <?php endforeach; ?>
            </tbody>
        </table>

    </main>

    <?php 
        
        //cerrar la conexión

        mysqli_close($db);

        incluirTemplate('footer'); 
        
    ?>