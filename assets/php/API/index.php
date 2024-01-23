<?php

require_once ("functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
        $datos = json_decode(file_get_contents("php://input"), true);
        $accion = $datos['accion'];
        $datos = $datos['datos'];
    } else {
        $accion = isset($_POST['accion']) ? $_POST['accion'] : null;
        $datos = $_POST;
        $datos['imagen'] = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;
    }

    switch ($accion){
        case 'registro':

            $resultadoRegistro = registrarUsuario($datos);
    
            if ($resultadoRegistro['exitoso']) {
                echo json_encode(['mensaje' => $resultadoRegistro['mensaje'], 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                http_response_code(500);
                echo json_encode(['mensaje' => $resultadoRegistro['mensaje'], 'tipo' => 'error']);
            }

            break;

        case 'login':

            $resultadoLogin = loginUsuario($datos);

            if ($resultadoLogin['exitoso']) {
                $sesion = new SesionUsuario();
                $sesion->setUsuario($resultadoLogin['id'], $resultadoLogin['nombre']);
                
                echo json_encode(['id_usuario' => $resultadoLogin['id'], 'nombre_usuario' => $resultadoLogin['nombre'],
                'mensaje' => 'BIENVENIDO ' . $resultadoLogin['nombre'] . '!!' , 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                echo json_encode(['mensaje' => $resultadoLogin['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }

            break;

        case 'subirArticulo':

            $nombre = isset($datos['nombre']) ? $datos['nombre'] : null;
            $existencias = isset($datos['existencias']) ? $datos['existencias'] : null;
            $categoria = isset($datos['categoria']) ? $datos['categoria'] : null;
            $marca = isset($datos['marca']) ? $datos['marca'] : null;
            $precio = isset($datos['precio']) ? $datos['precio'] : null;
            $sexo = isset($datos['sexo']) ? $datos['sexo'] : null;
            $descripcion = isset($datos['descripcion']) ? $datos['descripcion'] : null;
            $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;
        
            $resultadoSubirArticulo = subirArticulo($nombre, $existencias, $categoria, $marca, $precio, $sexo, $imagen, $descripcion);
        
            if ($resultadoSubirArticulo['exitoso']) {
                echo json_encode(['mensaje' => 'ARTÍCULO SUBIDO CORRECTAMENTE', 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                echo json_encode(['mensaje' => $resultadoSubirArticulo['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
        
            break;

        case 'modificarArticulo':

            $idArticulo = isset($datos['idArticulo']) ? $datos['idArticulo'] : null;
            $nombre = isset($datos['nombre']) ? $datos['nombre'] : null;
            $existencias = isset($datos['existencias']) ? $datos['existencias'] : null;
            $categoria = isset($datos['categoria']) ? $datos['categoria'] : null;
            $marca = isset($datos['marca']) ? $datos['marca'] : null;
            $precio = isset($datos['precio']) ? $datos['precio'] : null;
            $sexo = isset($datos['sexo']) ? $datos['sexo'] : null;
            $descripcion = isset($datos['descripcion']) ? $datos['descripcion'] : null;
            $imagen = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;
        
            $resultadoModificarArticulo = modificarArticulo($idArticulo, $nombre, $existencias, $categoria, $marca, $precio, $sexo, $imagen, $descripcion);
        
            if ($resultadoModificarArticulo['exitoso']) {
                echo json_encode(['mensaje' => 'ARTÍCULO MODIFICADO CORRECTAMENTE', 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                echo json_encode(['mensaje' => $resultadoModificarArticulo['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
        
            break;
          
        case 'borrarArticulo':

            $idArticulo = isset($datos['idArticulo']) ? $datos['idArticulo'] : null;

            $resultadoBorrarArticulo = borrarArticulo($idArticulo);

            if ($resultadoBorrarArticulo['exitoso']) {
                echo json_encode(['mensaje' => 'ARTÍCULO BORRADO CORRECTAMENTE', 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                echo json_encode(['mensaje' => $resultadoBorrarArticulo['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }

            break;


        case 'obtenerDetallesArticulo':

            $idProducto = isset($datos['idProducto']) ? $datos['idProducto'] : null;
            
            $detallesArticulo = obtenerDetallesArticulo($idProducto);
        
            if ($detallesArticulo['exitoso']) {
                echo json_encode(['tipo' => 'exitoso', 'detalles' => $detallesArticulo['detalles']]);
            } else {
                echo json_encode(['mensaje' => $detallesArticulo['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
            break;

        case 'enviarComentario':
            $sesionUsuario = new SesionUsuario();
            $idUsuario = $sesionUsuario->getID_Usuario();
            $idProducto = isset($datos['idProducto']) ? $datos['idProducto'] : null;
            $comentario = isset($datos['comentario']) ? $datos['comentario'] : null;

            $enviarComentario = enviarComentario($idUsuario, $idProducto, $comentario);
            $comentariosProducto = obtenerComentariosProducto($idProducto);

            if ($enviarComentario['exitoso']) {
                $respuesta = [
                    'tipo' => 'exitoso',
                    'mensaje' => $enviarComentario['mensaje'],
                    'comentarios' => $comentariosProducto
                ];
                echo json_encode($respuesta);
            } else {
                echo json_encode(['mensaje' => $enviarComentario['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
        
            break;

        case 'agregarAlCarrito':
            $sesionUsuario = new SesionUsuario();
            $idUsuario = $sesionUsuario->getID_Usuario();
            $idProducto = isset($datos['idProducto']) ? $datos['idProducto'] : null;

            $resultadoAgregarAlCarrito = agregarAlCarrito($idUsuario, $idProducto);

            if ($resultadoAgregarAlCarrito['exitoso']) {
                echo json_encode(['mensaje' => 'PRODUCTO AGREGADO AL CARRITO', 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                http_response_code(500);
                echo json_encode(['mensaje' => $resultadoAgregarAlCarrito['mensaje'], 'tipo' => 'error']);
            }

            break;

        case 'cargarTodosArticulos':

            $nombre = isset($datos['nombre']) ? $datos['nombre'] : null;

            $filtros = [ 'nombre' => $nombre ];

            $resultadoArticulos = cargarTodosArticulos($filtros);

            if ($resultadoArticulos['exitoso']) {
                echo json_encode(['articulos' => $resultadoArticulos['articulos'], 'tipo' => 'exitoso']);
            } else {
                echo json_encode(['mensaje' => $resultadoArticulos['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }

            break;

        case 'cargarArticulosDinamico':

            $categorias = isset($datos['categorias']) ? $datos['categorias'] : null;
            $marcas = isset($datos['marcas']) ? $datos['marcas'] : null;
            $sexo = isset($datos['sexo']) ? $datos['sexo'] : null;
            $nombre = isset($datos['nombre']) ? $datos['nombre'] : null;
            $pagina = isset($datos['pagina']) ? $datos['pagina'] : 1; 
        
            $filtros = [
                'categorias' => $categorias,
                'marcas' => $marcas,
                'sexo' => $sexo,
                'nombre' => $nombre
            ];
            
            $resultadoArticulos = cargarArticulos($filtros, $pagina);
        
            if ($resultadoArticulos['exitoso']) {
                echo json_encode(['articulos' => $resultadoArticulos['articulos'], 'totalPaginas' => $resultadoArticulos['totalPaginas']]);
            } else {
                echo json_encode(['mensaje' => $resultadoArticulos['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
        
            break;
            

        case 'detallesCarrito':
            $sesionUsuario = new SesionUsuario();
            $idUsuario = $sesionUsuario->getID_Usuario();
    
            $detallesCarrito = obtenerDetallesCarrito($idUsuario);
    
            if ($detallesCarrito['exitoso']) {
                echo json_encode(['tipo' => 'exitoso', 'productosCarrito' => $detallesCarrito['productosCarrito']]);
            } else {
                echo json_encode(['mensaje' => $detallesCarrito['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
            break;
    
        case 'eliminarProductoCarrito':
            $sesionUsuario = new SesionUsuario();
            $idUsuario = $sesionUsuario->getID_Usuario();
            $idProducto = isset($datos['idProducto']) ? $datos['idProducto'] : null;

            $resultadoEliminarProductoCarrito = eliminarProductoCarrito($idUsuario, $idProducto);

            if ($resultadoEliminarProductoCarrito['exitoso']) {
                echo json_encode(['mensaje' => $resultadoEliminarProductoCarrito['mensaje'], 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                echo json_encode(['mensaje' => $resultadoEliminarProductoCarrito['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
            break;

        case 'actualizarCantidadProducto':
            $sesionUsuario = new SesionUsuario();
            $idUsuario = $sesionUsuario->getID_Usuario();
            $idProducto = isset($datos['idProducto']) ? $datos['idProducto'] : null;
            $nuevaCantidad = isset($datos['cantidad']) ? $datos['cantidad'] : null;

            $resultadoActualizarCantidad = actualizarCantidadProducto($idUsuario, $idProducto, $nuevaCantidad);
        
            if ($resultadoActualizarCantidad['exitoso']) {
                echo json_encode(['mensaje' => $resultadoActualizarCantidad['mensaje'], 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                echo json_encode(['mensaje' => $resultadoActualizarCantidad['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
                break;

        case 'realizarPedido':

            $sesionUsuario = new SesionUsuario();
            $idUsuario = $sesionUsuario->getID_Usuario();
            $fechaActual = date("YmdHis");
            $codigoPedido = $fechaActual . $idUsuario;
            $totalPagar = isset($datos['totalPagar']) ? (float)$datos['totalPagar'] : 0;
        
            $resultadoRealizarPedido = realizarPedido($idUsuario, $totalPagar, $codigoPedido);
        
            if ($resultadoRealizarPedido['exitoso']) {
                echo json_encode(['tipo' => 'exitoso', 'mensaje' => $resultadoRealizarPedido['mensaje']]);

            } else {
                echo json_encode(['tipo' => 'error', 'mensaje' => $resultadoRealizarPedido['mensaje']]);
                http_response_code(500);
            }
            break;

        case 'cargarDatosUsuario':
            $sesionUsuario = new SesionUsuario();
            $idUsuario = $sesionUsuario->getID_Usuario();
            
            $datosUsuario = cargarDatosUsuario($idUsuario);
            
            if ($datosUsuario['exitoso']) {
                echo json_encode(['tipo' => 'exitoso', 'datosUsuario' => $datosUsuario['datos']]);
            } else {
                echo json_encode(['mensaje' => $datosUsuario['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
            break;

        case 'actualizarDatosUsuario':
            $sesionUsuario = new SesionUsuario();
            $idUsuario = $sesionUsuario->getID_Usuario();
            $nuevosDatos = isset($datos['nuevosDatos']) ? $datos['nuevosDatos'] : null;
        
            $resultadoActualizarDatos = actualizarDatosUsuario($idUsuario, $nuevosDatos);
        
            if ($resultadoActualizarDatos['exitoso']) {
                echo json_encode(['mensaje' => $resultadoActualizarDatos['mensaje'], 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                echo json_encode(['mensaje' => $resultadoActualizarDatos['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
            break;

        case 'cambiarContrasena':

            $sesionUsuario = new SesionUsuario();
            $idUsuario = $sesionUsuario->getID_Usuario();
            $contrasenaActual = isset($datos['contrasenaActual']) ? $datos['contrasenaActual'] : null;
            $nuevaContrasena = isset($datos['nuevaContrasena']) ? $datos['nuevaContrasena'] : null;
        
            $resultadoCambiarContrasena = cambiarContrasena($idUsuario, $contrasenaActual, $nuevaContrasena);
        
            if ($resultadoCambiarContrasena['exitoso']) {
                echo json_encode(['mensaje' => $resultadoCambiarContrasena['mensaje'], 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                echo json_encode(['mensaje' => $resultadoCambiarContrasena['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
        
            break;   
            
        case 'eliminarCuenta':
            $sesionUsuario = new SesionUsuario();
            $idUsuario = $sesionUsuario->getID_Usuario();
            $contrasena = isset($datos['contrasena']) ? $datos['contrasena'] : null;

            $resultadoEliminarCuenta = eliminarCuenta($idUsuario, $contrasena);

            if ($resultadoEliminarCuenta['exitoso']) {
                $sesionUsuario->cerrarSesion();
                echo json_encode(['mensaje' => $resultadoEliminarCuenta['mensaje'], 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                echo json_encode(['mensaje' => $resultadoEliminarCuenta['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
            break;
            
        case 'enviarCorreo':
            $nombre = isset($datos['nombre']) ? $datos['nombre'] : null;
            $correo = isset($datos['correo']) ? $datos['correo'] : null;
            $asunto = isset($datos['asunto']) ? $datos['asunto'] : null;
            $mensaje = isset($datos['mensaje']) ? $datos['mensaje'] : null;
        
            $resultadoEnviarCorreo = enviarCorreo($nombre, $correo, $asunto, $mensaje);
        
            if ($resultadoEnviarCorreo['exitoso']) {
                echo json_encode(['mensaje' => $resultadoEnviarCorreo['mensaje'], 'tipo' => 'exitoso', 'accion' => $accion]);
            } else {
                echo json_encode(['mensaje' => $resultadoEnviarCorreo['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
        
            break;            

        default:

            echo json_encode(['mensaje' => 'NO SE ENCONTRÓ LA ACCIÓN.', 'tipo' => 'error 404']);
            http_response_code(404);
           
            break;
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $accion = isset($_GET['accion']) ? $_GET['accion'] : null;

    $filtros = [];

    switch ($accion) {

    case 'cargarArticulosURL':

        $pagina = isset($_GET['pagina']) && $_GET['pagina'] !== null ? $_GET['pagina'] : 1;
    
        if (isset($_GET['marcas'])) {
            $filtros['marcas'] = ($_GET['marcas'] !== 'null') ? explode(',', $_GET['marcas']) : null;
        }
    
        if (isset($_GET['categorias'])) {
            $filtros['categorias'] = ($_GET['categorias'] !== 'null') ? explode(',', $_GET['categorias']) : null;
        }
    
        if (isset($_GET['sexo'])) {
            $filtros['sexo'] = ($_GET['sexo'] !== 'null') ? explode(',', $_GET['sexo']) : null;
        }
    
        $resultadoArticulos = cargarArticulos($filtros, $pagina);
    
        if ($resultadoArticulos['exitoso']) {
            echo json_encode(['filtros' => $filtros, 'articulos' => $resultadoArticulos['articulos'], 'totalPaginas' => $resultadoArticulos['totalPaginas']]);
        } else {
            echo json_encode(['mensaje' => $resultadoArticulos['mensaje'], 'tipo' => 'error']);
            http_response_code(500);
        }
    
        break;
        
        
        case 'cargarProductoID':
            $idProducto = isset($_GET['idProducto']) ? $_GET['idProducto'] : null;
        
            $detalleProducto = obtenerDetallesArticulo($idProducto);
            $comentariosProducto = obtenerComentariosProducto($idProducto);
        
            if ($detalleProducto['exitoso']) {
                $respuesta = [
                    'tipo' => 'exitoso',
                    'detalleProducto' => $detalleProducto['detalles'],
                    'comentariosProducto' => $comentariosProducto
                ];
                echo json_encode($respuesta);
            } else {
                echo json_encode(['mensaje' => $detalleProducto['mensaje'], 'tipo' => 'error']);
                http_response_code(500);
            }
            break;         

        case null:
            break;

        default:
            echo json_encode(['mensaje' => 'NO SE ENCONTRÓ LA ACCIÓN.', 'tipo' => 'error 404']);
            http_response_code(404);

            break;
    }
}


?>
