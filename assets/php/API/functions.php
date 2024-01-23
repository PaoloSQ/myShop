<?php

require_once ("Conexion.php");

class SesionUsuario{

    public function __construct() {
        session_start();
    }

    public function setUsuario($id, $nombre) {
        $_SESSION['id'] = $id;
        $_SESSION['user'] = $nombre;
    }

    public function getID_Usuario() {
        return isset($_SESSION['id']) ? $_SESSION['id'] : null;
    }

    public function getName_Usuario() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public function cerrarSesion(){
        session_unset();
        session_destroy();
    }
}

function registrarUsuario($datos) {
    
    $conexion = new Database();
    $conexion = $conexion->conectar();
  
    $nombre = $conexion->real_escape_string($datos['nombre']);
    $apellidos = $conexion->real_escape_string($datos['apellidos']);
    $provincia = $conexion->real_escape_string($datos['provincia']);
    $ciudad = $conexion->real_escape_string($datos['ciudad']);
    $direccion = $conexion->real_escape_string($datos['direccion']);
    $codigoPostal = $conexion->real_escape_string($datos['codigoPostal']);
    $telefono = $conexion->real_escape_string($datos['telefono']);
    $correo = $conexion->real_escape_string($datos['correo']);
    $contrasena = $conexion->real_escape_string($datos['contrasena']);

    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    //Verificación de correo existente

    $consultaCorreoExistente = "SELECT correo_usuario FROM usuarios WHERE correo_usuario = '$correo'";
    $resultadoadoCorreoExistente = $conexion->query($consultaCorreoExistente);

    if ($resultadoadoCorreoExistente->num_rows > 0) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => 'El correo ya está registrado.'];
    }

    //Verificación de telefono existente

    $consultaTelefonoExistente = "SELECT telefono_usuario FROM usuarios WHERE telefono_usuario = '$telefono'";
    $resultadoadoTelefonoExistente = $conexion->query($consultaTelefonoExistente);

    if ($resultadoadoTelefonoExistente->num_rows > 0) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => 'El teléfono ya está registrado.'];
    }

    $query = "INSERT INTO usuarios (nombre_usuario, apellido_usuario, provincia_usuario, ciudad_usuario, direccion_usuario, codigo_postal_usuario, telefono_usuario, correo_usuario, contrasena_usuario) 
              VALUES ('$nombre', '$apellidos', '$provincia', '$ciudad', '$direccion', '$codigoPostal', '$telefono', '$correo', '$contrasena_hash')";

    if ($conexion->query($query)) {
        $conexion->close();

        // Correo de bienvenida

        $headers = "From: $correo" . "\r\n" .
        "Reply-To: $correo" . "\r\n" .
        "X-Mailer: PHP/" . phpversion() . "\r\n" .
        "MIME-Version: 1.0" . "\r\n" .
        "Content-type: text/html; charset=UTF-8" . "\r\n";

        $mensajeHTML = "
            <html>
            <head>
                <title>Bienvenido a MyShop</title>
                <style>
                    body{
                        background-image: url('http://yoursearch.es/extras/fondo-email.jpg');
                        background-position: center;
                        background-size: cover;
                    }
                    .mensaje-container{
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        font-size: 2.5em;
                    }
                    .logo-container{
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 6%;
                        gap: 30px;
                        font-weight: bold;
                    }
                    .logo-container img{
                        width: 100%;
                    }
                    h1{
                        font-weight: bold;
                    }
                    p{
                        color: #000;
                    }
                </style>
            </head>
            <body>
                <div class='mensaje-container'>
                    <div class='logo-container'>
                        <img src='http://yoursearch.es/extras/logo_ico.ico' alt='Logo'>
                        <p>MyShop</p>
                    </div>
                    <h1>Hola $nombre,</h1>
                    <p>Bienvenido a MyShop!!</p>
                    <p>Gracias por registrarte!!</p>
                </div>
            </body>
        </html>
        ";

        return ['exitoso' => true, 'mensaje' => 'Usuario registrado correctamente.'];
        // $resultadoEnviarCorreo =  mail("admin@myshop.com", "Bienvenido a MyShop", $mensajeHTML, $headers);

        // if ($resultadoEnviarCorreo) {
        // } else {
        //     return ['exitoso' => true, 'mensaje' => 'Usuario registrado correctamente.'];
        // }

    } else {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => 'Error al registrar el usuario: ' . mysqli_error($conexion)];
    }

}


function loginUsuario($datos) {
    
    $conexion = new Database();
    $conexion = $conexion->conectar();
  
    $correo = $conexion->real_escape_string($datos['correo']);
    $contrasena = $conexion->real_escape_string($datos['contrasena']);

    $query = "SELECT id_usuario ,nombre_usuario, contrasena_usuario FROM usuarios WHERE correo_usuario = '$correo'";
    $resultado = $conexion->query($query);

    if ($resultado) {

        if ($resultado->num_rows > 0) {

            $row = $resultado->fetch_assoc();
            $id_usuario = $row['id_usuario'];
            $nombreUsuario = $row['nombre_usuario'];
            $resultadoadoContrasena = $row['contrasena_usuario'];

            if (password_verify($contrasena, $resultadoadoContrasena)) {
                $conexion->close();
                return ['exitoso' => true, 'nombre' => $nombreUsuario, 'id' => $id_usuario];
            } else {
                $conexion->close();
                return ['exitoso' => false, 'mensaje' => 'CONTRASEÑA INCORRECTA'];
            }
        } else {
            $conexion->close();
            return ['exitoso' => false, 'mensaje' => 'EL CORREO NO EXISTE'];
        }
    } else {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => 'ERROR EN LA BASE DE DATOS: ' . mysqli_error($conexion)];
    }
}


function subirArticulo($nombre, $existencias, $categoria, $marca, $precio, $sexo, $imagen, $descripcion) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    $nombre = $conexion->real_escape_string(strtoupper($nombre));
    $existencias = $conexion->real_escape_string($existencias);
    $categoria = $conexion->real_escape_string(strtoupper($categoria));
    $marca = $conexion->real_escape_string(strtoupper($marca));
    $precio = $conexion->real_escape_string($precio);
    $sexo = $conexion->real_escape_string(strtoupper($sexo));
    $nombreBusqueda = strtoupper($nombre . $categoria . $marca . $sexo);
    $descripcion = $conexion->real_escape_string(strtoupper($descripcion));
    $imagenURL = '';

    $carpetaMarca =  'assets/img/articulos/' . $marca;
    $urlCopy = dirname(__FILE__) . '/../../../' . $carpetaMarca;

    try {
        if (!file_exists($urlCopy)) {
            throw new Exception('La carpeta de la marca no existe.');
        }

        if (!isset($imagen) || $imagen['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Hubo un problema con la imagen.');
        }

        $query = $conexion->prepare("INSERT INTO productos (nombre_producto, nombreBusqueda_producto, existencias_producto, categoria_producto, marca_producto, precio_producto, descripcion_producto, sexo_producto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param('ssissdss', $nombre, $nombreBusqueda, $existencias, $categoria, $marca, $precio, $descripcion, $sexo);

        if ($query->execute()) {

            $idProducto = $query->insert_id;
            $nombreImagen = 'id_' . $idProducto . '.webp';
            $imagenURL = $carpetaMarca .'/' . $nombreImagen;

            $queryUpdate = $conexion->prepare("UPDATE productos SET imagenURL_producto = ? WHERE id_producto = ?");
            $queryUpdate->bind_param('si', $imagenURL, $idProducto);

            if ($queryUpdate->execute()) {

                if (!move_uploaded_file($imagen['tmp_name'], $urlCopy . '/' . $nombreImagen)) {
                    throw new Exception('Hubo un problema al subir la imagen.');
                }

                $conexion->close();
                return ['exitoso' => true];
            } else {
                throw new Exception('Error al actualizar la URL de la imagen: ' . $queryUpdate->error);
            }
        } else {
            throw new Exception('Error al subir el artículo: ' . $query->error);
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }

}


function modificarArticulo($idArticulo, $nombre, $existencias, $categoria, $marca, $precio, $sexo, $imagen, $descripcion) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {
        if (!is_numeric($idArticulo) || $idArticulo <= 0) {
            throw new Exception('ID de artículo no válido.');
        }

        $nombre = $conexion->real_escape_string(strtoupper($nombre));
        $existencias = $conexion->real_escape_string($existencias);
        $categoria = $conexion->real_escape_string(strtoupper($categoria));
        $marca = $conexion->real_escape_string(strtoupper($marca));
        $precio = $conexion->real_escape_string($precio);
        $sexo = $conexion->real_escape_string(strtoupper($sexo));
        $nombreBusqueda = strtoupper($nombre . $categoria . $marca . $sexo);
        $descripcion = $conexion->real_escape_string(strtoupper($descripcion));
        $imagenURL = '';

        $carpetaMarca =  'assets/img/articulos/' . $marca;
        $urlCopy = dirname(__FILE__) . '/../../../' . $carpetaMarca;

        if (!file_exists($urlCopy)) {
            throw new Exception('La carpeta de la marca no existe.');
        }

        if (isset($imagen) && $imagen['error'] === UPLOAD_ERR_OK) {
            $nombreImagen = 'id_' . $idArticulo . '.webp';
            $imagenURL = $carpetaMarca . '/' . $nombreImagen;

            $queryUpdate = $conexion->prepare("UPDATE productos SET nombre_producto = ?, nombreBusqueda_producto = ?, existencias_producto = ?, categoria_producto = ?, marca_producto = ?, precio_producto = ?, descripcion_producto = ?, sexo_producto = ?, imagenURL_producto = ? WHERE id_producto = ?");
            $queryUpdate->bind_param('ssissdssi', $nombre, $nombreBusqueda, $existencias, $categoria, $marca, $precio, $descripcion, $sexo, $imagenURL, $idArticulo);
        } else {
            $queryUpdate = $conexion->prepare("UPDATE productos SET nombre_producto = ?, nombreBusqueda_producto = ?, existencias_producto = ?, categoria_producto = ?, marca_producto = ?, precio_producto = ?, descripcion_producto = ?, sexo_producto = ? WHERE id_producto = ?");
            $queryUpdate->bind_param('ssissdssi', $nombre, $nombreBusqueda, $existencias, $categoria, $marca, $precio, $descripcion, $sexo, $idArticulo);
        }

        if ($queryUpdate->execute()) {
            if ($imagenURL !== '') {
                if (!move_uploaded_file($imagen['tmp_name'], $urlCopy . '/' . $nombreImagen)) {
                    throw new Exception('Hubo un problema al subir la imagen.');
                }
            }

            $conexion->close();
            return ['exitoso' => true];
        } else {
            throw new Exception('Error al actualizar el artículo: ' . $queryUpdate->error);
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}



function obtenerDetallesArticulo($idProducto) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    $idProducto = intval($idProducto);

    try {
        if (!is_numeric($idProducto) || $idProducto <= 0) {
            throw new Exception('ID de artículo no válido.');
        }
        
        $query = $conexion->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $query->bind_param('i', $idProducto);
        
        
        
        if ($query->execute()) {
            $resultados = $query->get_result();
            
            if ($resultados->num_rows > 0) {
                $detalles = $resultados->fetch_assoc();
                $conexion->close();
                return ['exitoso' => true, 'detalles' => $detalles];
            } else {
                throw new Exception('No se encontraron detalles para el artículo.');
            }
        } else {
            throw new Exception('Error al obtener detalles del artículo: ' . $query->error);
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}


function obtenerComentariosProducto($idProducto) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    $idProducto = intval($idProducto);

    try {
        if (!is_numeric($idProducto) || $idProducto <= 0) {
            throw new Exception('ID de artículo no válido.');
        }

        $query = $conexion->prepare("
            SELECT c.*, u.nombre_usuario
            FROM comentarios c
            INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
            WHERE c.id_producto = ?
        ");
        $query->bind_param('i', $idProducto);

        if ($query->execute()) {
            $resultados = $query->get_result();

            $comentarios = [];
            while ($fila = $resultados->fetch_assoc()) {
                $comentarios[] = $fila;
            }

            $conexion->close();
            return $comentarios;
        } else {
            throw new Exception('Error al obtener comentarios del artículo: ' . $query->error);
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}



function enviarComentario($idUsuario, $idProducto, $comentario) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {
        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            throw new Exception('ID de usuario no válido.');
        }

        if (!is_numeric($idProducto) || $idProducto <= 0) {
            throw new Exception('ID de artículo no válido.');
        }

        $query = $conexion->prepare("INSERT INTO comentarios (id_usuario, id_producto, comentario) VALUES (?, ?, ?)");
        $query->bind_param('iis', $idUsuario, $idProducto, $comentario);
        
        if ($query->execute()) {
            $conexion->close();
            return ['exitoso' => true, 'mensaje' => 'Comentario introducido correctamente!!'];
        } else {
            throw new Exception('Error al enviar el comentario');
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}




function agregarAlCarrito($idUsuario, $idProducto) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {
        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            throw new Exception('ID de usuario no válido.');
        }

        if (!is_numeric($idProducto) || $idProducto <= 0) {
            throw new Exception('ID de producto no válido.');
        }

        $queryVerificar = $conexion->prepare("SELECT cantidad_producto FROM carritos WHERE id_usuario = ? AND id_producto = ?");
        $queryVerificar->bind_param('ii', $idUsuario, $idProducto);
        $queryVerificar->execute();
        $resultadosVerificar = $queryVerificar->get_result();

        if ($resultadosVerificar->num_rows > 0) {
            $row = $resultadosVerificar->fetch_assoc();
            $cantidadExistente = $row['cantidad_producto'] + 1;

            $queryUpdate = $conexion->prepare("UPDATE carritos SET cantidad_producto = ? WHERE id_usuario = ? AND id_producto = ?");
            $queryUpdate->bind_param('iii', $cantidadExistente, $idUsuario, $idProducto);
            $queryUpdate->execute();

            if ($queryUpdate->affected_rows <= 0) {
                throw new Exception('Error al actualizar la cantidad en el carrito.');
            }
        } else {
            $queryInsert = $conexion->prepare("INSERT INTO carritos (id_usuario, id_producto, cantidad_producto) VALUES (?, ?, 1)");
            $queryInsert->bind_param('ii', $idUsuario, $idProducto);
            $queryInsert->execute();

            if ($queryInsert->affected_rows <= 0) {
                throw new Exception('Error al agregar el producto al carrito.');
            }
        }

        $conexion->close();
        return ['exitoso' => true];
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}

function obtenerDetallesCarrito($idUsuario) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {
        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            throw new Exception('ID de usuario no válido.');
        }

        $query = $conexion->prepare("
            SELECT p.id_producto, p.nombre_producto, p.existencias_producto, p.imagenURL_producto, p.precio_producto, c.cantidad_producto,
                   (p.precio_producto * c.cantidad_producto) AS monto_total
            FROM carritos c
            INNER JOIN productos p ON c.id_producto = p.id_producto
            WHERE c.id_usuario = ?
        ");
        $query->bind_param('i', $idUsuario);

        if ($query->execute()) {
            $resultados = $query->get_result();
            $detallesCarrito = $resultados->fetch_all(MYSQLI_ASSOC);
            
            $conexion->close();
            return ['exitoso' => true, 'productosCarrito' => $detallesCarrito];
        } else {
            throw new Exception('Error al obtener detalles del carrito: ' . $query->error);
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}


function eliminarProductoCarrito($idUsuario, $idProducto) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {
        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            throw new Exception('ID de usuario no válido.');
        }

        if (!is_numeric($idProducto) || $idProducto <= 0) {
            throw new Exception('ID de producto no válido.');
        }

        $queryEliminar = $conexion->prepare("DELETE FROM carritos WHERE id_usuario = ? AND id_producto = ?");
        $queryEliminar->bind_param('ii', $idUsuario, $idProducto);

        if ($queryEliminar->execute()) {
            $conexion->close();
            return ['exitoso' => true, 'mensaje' => 'Producto eliminado del carrito'];
        } else {
            throw new Exception('Error al eliminar el producto del carrito: ' . $queryEliminar->error);
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}


function actualizarCantidadProducto($idUsuario, $idProducto, $nuevaCantidad) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {
        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            throw new Exception('ID de usuario no válido.');
        }

        if (!is_numeric($idProducto) || $idProducto <= 0) {
            throw new Exception('ID de producto no válido.');
        }

        if (!is_numeric($nuevaCantidad) || $nuevaCantidad < 0) {
            throw new Exception('Cantidad no válida.');
        }

        $queryVerificar = $conexion->prepare("SELECT cantidad_producto FROM carritos WHERE id_usuario = ? AND id_producto = ?");
        $queryVerificar->bind_param('ii', $idUsuario, $idProducto);
        $queryVerificar->execute();
        $resultadosVerificar = $queryVerificar->get_result();

        if ($resultadosVerificar->num_rows > 0) {
            $row = $resultadosVerificar->fetch_assoc();
            $queryUpdate = $conexion->prepare("UPDATE carritos SET cantidad_producto = ? WHERE id_usuario = ? AND id_producto = ?");
            $queryUpdate->bind_param('iii', $nuevaCantidad, $idUsuario, $idProducto);
            $queryUpdate->execute();

            if ($queryUpdate->affected_rows <= 0) {
                throw new Exception('Error al actualizar la cantidad en el carrito.');
            }

            $conexion->close();
            return ['exitoso' => true, 'mensaje' => 'Cantidad actualizada correctamente en el carrito.'];
        } else {
            throw new Exception('El producto no está en el carrito del usuario.');
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}



function realizarPedido($idUsuario, $totalPagar, $codigoPedido) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {
        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            throw new Exception('ID de usuario no válido.');
        }

        if (!is_numeric($totalPagar) || $totalPagar <= 0) {
            throw new Exception('Monto a pagar no válido.');
        }

        if (empty($codigoPedido)) {
            throw new Exception('Código de pedido no válido.');
        }

        $detallesCarrito = obtenerDetallesCarrito($idUsuario);
        if (empty($detallesCarrito['productosCarrito'])) {
            throw new Exception('El carrito está vacío. No se puede realizar el pedido.');
        }

        $conexion->autocommit(false);

        foreach ($detallesCarrito['productosCarrito'] as $producto) {
            $idProducto = $producto['id_producto'];
            $nombreProducto = $producto['nombre_producto'];
            $cantidadProducto = $producto['cantidad_producto'];
        
            $queryExistencias = $conexion->prepare("SELECT existencias_producto FROM productos WHERE id_producto = ?");
            $queryExistencias->bind_param('i', $idProducto);
            $queryExistencias->execute();
            $resultExistencias = $queryExistencias->get_result();
        
            if ($resultExistencias->num_rows > 0) {
                $rowExistencias = $resultExistencias->fetch_assoc();
                $existenciasProducto = $rowExistencias['existencias_producto'];
        
                if ($existenciasProducto < $cantidadProducto) {
                    throw new Exception('No hay stock suficiente para el producto: ' . $nombreProducto);
                }
        
                $nuevoStock = $existenciasProducto - $cantidadProducto;
                $queryActualizarStock = $conexion->prepare("UPDATE productos SET existencias_producto = ? WHERE id_producto = ?");
                $queryActualizarStock->bind_param('ii', $nuevoStock, $idProducto);
        
                if (!$queryActualizarStock->execute()) {
                    throw new Exception('Error al actualizar el stock del producto: ' . $queryActualizarStock->error);
                }
            } else {
                throw new Exception('No se encontró el producto con ID ' . $idProducto);
            }        

            $fechaPedido = date("Y-m-d");

            $queryInsertPedido = $conexion->prepare("INSERT INTO pedidos (codigo_pedido, id_usuario, id_productos, cantidad_producto, total_pagar, fecha_pedido) VALUES (?, ?, ?, ?, ?, ?)");
            $queryInsertPedido->bind_param('siiids', $codigoPedido, $idUsuario, $idProducto, $cantidadProducto, $totalPagar, $fechaPedido);

            if (!$queryInsertPedido->execute()) {
                throw new Exception('Error al insertar el producto en la tabla de pedidos: ' . $queryInsertPedido->error);
            }
        }

        $queryDeleteCarrito = $conexion->prepare("DELETE FROM carritos WHERE id_usuario = ?");
        $queryDeleteCarrito->bind_param('i', $idUsuario);
        
        if (!$queryDeleteCarrito->execute()) {
            throw new Exception('Error al borrar el carrito del usuario: ' . $queryDeleteCarrito->error);
        }

        $conexion->commit();
        $conexion->autocommit(true);

        $conexion->close();
        return ['exitoso' => true, 'mensaje' => 'Compra realizada exitosamente. Código de pedido: ' . $codigoPedido];
    } catch (Exception $e) {

        $conexion->rollback();
        $conexion->autocommit(true);
        $conexion->close();

        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}


function cargarDatosUsuario($idUsuario) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    $resultado = [];

    try {
        $queryDatosUsuario = $conexion->prepare("SELECT id_usuario, nombre_usuario, apellido_usuario, provincia_usuario, ciudad_usuario, direccion_usuario, codigo_postal_usuario, telefono_usuario, correo_usuario FROM usuarios WHERE id_usuario = ?");
        $queryDatosUsuario->bind_param('i', $idUsuario);

        if (!$queryDatosUsuario->execute()) {
            throw new Exception('Error al obtener los datos del usuario: ' . $queryDatosUsuario->error);
        }

        $resultDatosUsuario = $queryDatosUsuario->get_result();

        if ($resultDatosUsuario->num_rows > 0) {
            $resultado['datosUsuario'] = $resultDatosUsuario->fetch_assoc();

            $queryPedidosUsuario = $conexion->prepare(
                "SELECT 
                    pd.id_pedido,
                    pd.codigo_pedido,
                    pd.id_usuario,
                    pd.id_productos,
                    pd.cantidad_producto,
                    pd.total_pagar,
                    pd.fecha_pedido,
                    pr.nombre_producto,
                    pr.marca_producto,
                    pr.imagenURL_producto,
                    pr.precio_producto
                FROM pedidos pd
                JOIN productos pr ON pd.id_productos = pr.id_producto
                WHERE pd.id_usuario = ?");
            $queryPedidosUsuario->bind_param('i', $idUsuario);

            if (!$queryPedidosUsuario->execute()) {
                throw new Exception('Error al obtener los pedidos del usuario: ' . $queryPedidosUsuario->error);
            }

            $resultPedidosUsuario = $queryPedidosUsuario->get_result();

            $pedidosUsuario = [];
            while ($row = $resultPedidosUsuario->fetch_assoc()) {
                $pedidosUsuario[] = $row;
            }

            $resultado['pedidosUsuario'] = $pedidosUsuario;
        } else {
            throw new Exception('Usuario no encontrado.');
        }

        $queryDatosUsuario->close();
        $queryPedidosUsuario->close();
        $conexion->close();
        return ['exitoso' => true, 'mensaje' => 'Usuario cargado correctamente', 'datos' => $resultado];

    } catch (Exception $e) {
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}


function actualizarDatosUsuario($idUsuario, $nuevosDatos) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {
        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            throw new Exception('ID de usuario no válido.');
        }

        $nombre = $conexion->real_escape_string($nuevosDatos['nombre']);
        $apellido = $conexion->real_escape_string($nuevosDatos['apellido']);
        $provincia = $conexion->real_escape_string($nuevosDatos['provincia']);
        $ciudad = $conexion->real_escape_string($nuevosDatos['ciudad']);
        $direccion = $conexion->real_escape_string($nuevosDatos['direccion']);
        $codigoPostal = $conexion->real_escape_string($nuevosDatos['codigoPostal']);
        $telefono = $conexion->real_escape_string($nuevosDatos['telefono']);
        $correo = $conexion->real_escape_string($nuevosDatos['correo']);

        $query = $conexion->prepare("
            UPDATE usuarios 
            SET nombre_usuario = ?, apellido_usuario = ?, provincia_usuario = ?, ciudad_usuario = ?, direccion_usuario = ?, codigo_postal_usuario = ?, telefono_usuario = ?, correo_usuario = ?
            WHERE id_usuario = ?
        ");

        $query->bind_param('ssssssssi', $nombre, $apellido, $provincia, $ciudad, $direccion, $codigoPostal, $telefono, $correo, $idUsuario);

        if ($query->execute()) {
            $conexion->close();
            return ['exitoso' => true, 'mensaje' => 'Datos de usuario actualizados correctamente.'];
        } else {
            throw new Exception('Error al actualizar los datos del usuario: ' . $query->error);
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}


function cambiarContrasena($idUsuario, $contrasenaActual, $nuevaContrasena) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {
        $idUsuario = intval($idUsuario);

        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            throw new Exception('ID de usuario no válido.');
        }

        $contrasenaActual = $conexion->real_escape_string($contrasenaActual);
        $nuevaContrasena = $conexion->real_escape_string($nuevaContrasena);

        $query = $conexion->prepare("SELECT contrasena_usuario FROM usuarios WHERE id_usuario = ?");
        $query->bind_param('i', $idUsuario);

        if (!$query->execute()) {
            throw new Exception('Error al obtener la contraseña del usuario: ' . $query->error);
        }

        $resultados = $query->get_result();

        if ($resultados->num_rows > 0) {
            $row = $resultados->fetch_assoc();
            $contrasenaBD = $row['contrasena_usuario'];

            if (password_verify($contrasenaActual, $contrasenaBD)) {
                $nuevaContrasenaHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

                $queryUpdate = $conexion->prepare("UPDATE usuarios SET contrasena_usuario = ? WHERE id_usuario = ?");
                $queryUpdate->bind_param('si', $nuevaContrasenaHash, $idUsuario);

                if ($queryUpdate->execute()) {
                    $conexion->close();
                    return ['exitoso' => true, 'mensaje' => 'Contraseña actualizada correctamente.'];
                } else {
                    throw new Exception('Error al actualizar la contraseña: ' . $queryUpdate->error);
                }
            } else {
                throw new Exception('La contraseña es incorrecta.');
            }
        } else {
            throw new Exception('Usuario no encontrado.');
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}

function enviarCorreo($nombre, $correo, $asunto, $mensaje) {

    $destinatario = 'ben281909@gmail.com';

    $mensajeCompleto = "Nombre: $nombre\r\n" . 
                       "Mensaje: $mensaje";

    $headers = "From: $correo" . "\r\n" .
               "Reply-To: $correo" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    $resultado = mail($destinatario, $asunto, $mensajeCompleto, $headers);

    if ($resultado) {
        return ['exitoso' => true, 'mensaje' => 'Correo enviado correctamente.'];
    } else {
        $error = error_get_last();
        return ['exitoso' => false, 'mensaje' => 'Error al enviar el correo: ' . $error['message']];
    }
}


function eliminarCuenta($idUsuario, $contrasena) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {
        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            throw new Exception('ID de usuario no válido.');
        }

        $queryContrasena = $conexion->prepare("SELECT contrasena_usuario FROM usuarios WHERE id_usuario = ?");
        $queryContrasena->bind_param('i', $idUsuario);

        if (!$queryContrasena->execute()) {
            throw new Exception('Error al obtener la contraseña del usuario: ' . $queryContrasena->error);
        }

        $resultContrasena = $queryContrasena->get_result();

        if ($resultContrasena->num_rows > 0) {
            $row = $resultContrasena->fetch_assoc();
            $contrasenaBD = $row['contrasena_usuario'];

            if (password_verify($contrasena, $contrasenaBD)) {

                $queryEliminarCarrito = $conexion->prepare("DELETE FROM carritos WHERE id_usuario = ?");
                $queryEliminarCarrito->bind_param('i', $idUsuario);

                if (!$queryEliminarCarrito->execute()) {
                    throw new Exception('Error al eliminar el carrito del usuario: ' . $queryEliminarCarrito->error);
                }

                $queryEliminarUsuario = $conexion->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
                $queryEliminarUsuario->bind_param('i', $idUsuario);

                if ($queryEliminarUsuario->execute()) {
                    $conexion->close();
                    return ['exitoso' => true, 'mensaje' => 'Cuenta eliminada correctamente.'];
                } else {
                    throw new Exception('Error al eliminar la cuenta del usuario: ' . $queryEliminarUsuario->error);
                }
            } else {
                throw new Exception('Contraseña incorrecta.');
            }
        } else {
            throw new Exception('Usuario no encontrado.');
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}



function borrarArticulo($idArticulo) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    try {

        if (!is_numeric($idArticulo) || $idArticulo <= 0) {
            throw new Exception('ID de artículo no válido.');
        }

        $query = $conexion->prepare("DELETE FROM productos WHERE id_producto = ?");
        $query->bind_param('i', $idArticulo);

        if ($query->execute()) {
            $conexion->close();
            return ['exitoso' => true];
        } else {
            throw new Exception('Error al borrar el artículo: ' . $query->error);
        }
    } catch (Exception $e) {
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $e->getMessage()];
    }
}

function cargarTodosArticulos($filtros) {
    $conexion = new Database();
    $conexion = $conexion->conectar();

    $marcas = isset($filtros['marcas']) ? $filtros['marcas'] : [];
    $categorias = isset($filtros['categorias']) ? $filtros['categorias'] : [];
    $sexo = isset($filtros['sexo']) ? $filtros['sexo'] : [];
    $nombre = isset($filtros['nombre']) ? $filtros['nombre'] : [];

    $marcas = array_map([$conexion, 'real_escape_string'], $marcas);
    $categorias = array_map([$conexion, 'real_escape_string'], $categorias);
    $sexo = array_map([$conexion, 'real_escape_string'], $sexo);
    $nombre = array_map([$conexion, 'real_escape_string'], $nombre);

    $condiciones = [];

    if (!empty($marcas)) {
        $marcasCondicion = "marca_producto IN ('" . implode("','", $marcas) . "')";
        $condiciones[] = "UPPER($marcasCondicion)";
    }

    if (!empty($categorias)) {
        $categoriasCondicion = "categoria_producto IN ('" . implode("','", $categorias) . "')";
        $condiciones[] = "UPPER($categoriasCondicion)";
    }

    if (!empty($sexo)) {
        $sexoCondicion = "sexo_producto IN ('" . implode("','", $sexo) . "')";
        $condiciones[] = "UPPER($sexoCondicion)";
    }

    if (!empty($nombre)) {
        $nombreCondiciones = [];
        foreach ($nombre as $nombreValor) {
            $nombreCondiciones[] = "UPPER(nombre_producto) LIKE '%" . strtoupper($nombreValor) . "%'";
        }
        $condiciones[] = '(' . implode(' AND ', $nombreCondiciones) . ')';
    }

    $condicionesSQL = implode(" AND ", $condiciones);

    $query = "SELECT id_producto, nombre_producto, existencias_producto, imagenURL_producto, precio_producto FROM productos";
    if ($condicionesSQL) {
        $query .= " WHERE " . $condicionesSQL;
    }

    $resultados = $conexion->query($query);

    if ($resultados) {
        $articulos = $resultados->fetch_all(MYSQLI_ASSOC);
        $conexion->close();
        return ['exitoso' => true, 'articulos' => $articulos];
    } else {
        $errorMensaje = 'Error al cargar artículos: ' . $conexion->error;
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $errorMensaje];
    }
}


function cargarArticulos($filtros, $pagina) {
    $conexion = new Database();
    $conexion = $conexion->conectar();
    
    $marcas = isset($filtros['marcas']) ? $filtros['marcas'] : [];
    $categorias = isset($filtros['categorias']) ? $filtros['categorias'] : [];
    $sexo = isset($filtros['sexo']) ? $filtros['sexo'] : [];
    $nombre = isset($filtros['nombre']) ? $filtros['nombre'] : [];
    
    $marcas = array_map([$conexion, 'real_escape_string'], $marcas);
    $categorias = array_map([$conexion, 'real_escape_string'], $categorias);
    $sexo = array_map([$conexion, 'real_escape_string'], $sexo);
    $nombre = array_map([$conexion, 'real_escape_string'], $nombre);
    
    $condiciones = [];

    if (!empty($marcas)) {
        $marcasCondicion = "marca_producto IN ('" . implode("','", $marcas) . "')";
        $condiciones[] = "UPPER($marcasCondicion)";
    }
    
    if (!empty($categorias)) {
        $categoriasCondicion = "categoria_producto IN ('" . implode("','", $categorias) . "')";
        $condiciones[] = "UPPER($categoriasCondicion)";
    }
    
    if (!empty($sexo)) {
        $sexoCondicion = "sexo_producto IN ('" . implode("','", $sexo) . "')";
        $condiciones[] = "UPPER($sexoCondicion)";
    }

    if (!empty($nombre)) {
        $nombreCondiciones = [];
        foreach ($nombre as $nombreValor) {
            $nombreCondiciones[] = "UPPER(nombreBusqueda_producto) LIKE '%" . strtoupper($nombreValor) . "%'";
        }
        $condiciones[] = '(' . implode(' AND ', $nombreCondiciones) . ')';
    }

    $condicionesSQL = implode(" AND ", $condiciones);
    
    $queryContador = "SELECT COUNT(*) as total FROM productos";
    if ($condicionesSQL) {
        $queryContador .= " WHERE " . $condicionesSQL;
    }
    $resultadoContador = $conexion->query($queryContador);
    $totalFilas = $resultadoContador->fetch_assoc()['total'];
    
    $filasPorPagina = 20;
    $totalPaginas = ceil($totalFilas / $filasPorPagina);
    
    $offset = ($pagina - 1) * $filasPorPagina;

    $query = "SELECT id_producto, nombre_producto, existencias_producto, imagenURL_producto, precio_producto FROM productos";
    if ($condicionesSQL) {
        $query .= " WHERE " . $condicionesSQL;
    }
    $query .= " LIMIT $filasPorPagina OFFSET $offset";
    $resultados = $conexion->query($query);
    
    if ($resultados) {
        $articulos = $resultados->fetch_all(MYSQLI_ASSOC);
        $conexion->close();
        return ['exitoso' => true, 'articulos' => $articulos, 'totalPaginas' => $totalPaginas];
    } else {
        $errorMensaje = 'Error al cargar artículos: ' . $conexion->error;
        $conexion->close();
        return ['exitoso' => false, 'mensaje' => $errorMensaje];
    }
}



?>
