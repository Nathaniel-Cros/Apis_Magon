<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
/** Ruta para productos */
$app->get('/product/products', function (Request $request, Response $response){
    $sql = "SELECT * FROM productos";
    try{
        $db = new db();
        $db = $db->conexionDB();
        $result = $db->query($sql);
        if( $result->rowCount() > 0 ){
            $productos = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($productos);
        }else{
            echo json_encode("No existen productos en la base de datos");
        }
        //$db->closeCursor();
        $db = null;
        $result = null;

    }catch(PDOException $e){
        echo '{"error" : { "text": "'.$e->getMessage().'"}';
    }
});
/** Ruta para un producto */
$app->get('/product/{id}', function(Request $request, Response $response){
    $id_producto = $request->getAttribute('id');
    $sql = "SELECT * FROM productos WHERE id = $id_producto";
    try{
        $db = new db();
        $db = $db->conexionDB();
        $result = $db->query($sql);
        if( $result->rowCount() > 0 ){
            $productos = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($productos);
        }else{
            echo json_encode("No existe el producto con ese ID : $id_producto .");
        }
        //$db->closeCursor();
        $db = null;
        $result = null;

    }catch(PDOException $e){
        echo '{"error" : { "text": "'.$e->getMessage().'"}';
    }
});
/** Ruta POST crea un nuevo producto */
$app->post('/product/add', function(Request $request, Response $response){

    $idproductor = $request->getParam('idproductor');
    $titulo = $request->getParam('titulo');
    $descripcion = $request->getParam('descripcion');
    $precio = $request->getParam('precio');
    $image = $request->getParam('image');
    $tipoproducto = $request->getParam('tipoproducto');

    $sql = "INSERT INTO productos (idproductor, titulo, descripcion, precio, image, tipoproducto) VALUES
            (:idproductor, :titulo, :descripcion, :precio, :image, :tipoproducto)";
    
    try{
        $db = new db();
        $db = $db->conexionDB();
        $result = $db->prepare($sql);

        $result->bindParam(':idproductor', $idproductor);
        $result->bindParam(':titulo', $titulo);
        $result->bindParam(':descripcion', $descripcion);
        $result->bindParam(':precio', $precio);
        $result->bindParam(':image', $image);
        $result->bindParam(':tipoproducto', $tipoproducto);

        $result->execute();

        echo json_encode("Nuevo Producto Guardado");

        $result->closeCursor();
        $db = null;
        $result = null;

    }catch(PDOException $e){
        echo '{"error" : { "text": "'.$e->getMessage().'"}';
    }
});

/** Ruta PUT modificacion producto */
$app->put('/product/modifica/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $idproductor = $request->getParam('idproductor');
    $titulo = $request->getParam('titulo');
    $descripcion = $request->getParam('descripcion');
    $precio = $request->getParam('precio');
    $image = $request->getParam('image');
    $tipoproducto = $request->getParam('tipoproducto');

    $sql = "UPDATE productos SET
            idproductor = :idproductor,
            titulo = :titulo,
            descripcion = :descripcion,
            precio = :precio,
            image = :image,
            tipoproducto = :tipoproducto
            WHERE id = $id";
    
    try{
        $db = new db();
        $db = $db->conexionDB();
        $result = $db->prepare($sql);

        $result->bindParam(':idproductor', $idproductor);
        $result->bindParam(':titulo', $titulo);
        $result->bindParam(':descripcion', $descripcion);
        $result->bindParam(':precio', $precio);
        $result->bindParam(':image', $image);
        $result->bindParam(':tipoproducto', $tipoproducto);

        $result->execute();

        echo json_encode("Producto Modificado");

        $result->closeCursor();
        $db = null;
        $result = null;

    }catch(PDOException $e){
        echo '{"error" : { "text": "'.$e->getMessage().'"}';
    }
});

/** Ruta DELETE para borrar producto */
$app->delete('/product/delete/{id}', function (Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM productos WHERE id = $id";
    try{
        $db = new db();
        $db = $db->conexionDB();
        $result = $db->prepare($sql);
        $result->execute();
        if( $result->rowCount() > 0 ){
            echo json_encode("Producto Eliminado");
        }else{
            echo json_encode("No existe el producto con el ID: $id");
        }
        //$db->closeCursor();
        $db = null;
        $result = null;

    }catch(PDOException $e){
        echo '{"error" : { "text": "'.$e->getMessage().'"}';
    }
});
