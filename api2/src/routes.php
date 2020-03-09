<?php 
$app->add(function ($req, $res, $next) {
   $response = $next($req, $res);
   return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token, Access-Control-Allow-Origin, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

use Slim\Http\Request;
use Slim\Http\Response;




$app->get('/articulos', function(Request $request, Response $response, array $args){
  $sth = $this-> db -> prepare('SELECT * FROM articulos ORDER BY tipo');
  $sth -> execute();
  $art = $sth->fetchAll();
  echo json_encode($art);
});


$app->post('/articulos.add', function(Request $request, Response $response, array $args){
  $datos = $request -> getParsedBody();
  $sth = $this->db->prepare('INSERT INTO articulos(nombre,talla,costo,foto,genero) VALUES(:nombre,:talla,:costo,:foto,:genero)');

  $sth -> bindParam('nombre'     , $datos['nombre']);
  $sth -> bindParam('talla'     , $datos['talla']);
  $sth -> bindParam('costo', $datos['costo']);
  $sth -> bindParam('foto'      , $datos['foto']);
  // $sth -> bindParam('tipo'      , $datos['tipo']);
  $sth -> bindParam('genero'      , $datos['genero']);

  if($sth -> execute()){
    echo "Insertado Correctamente";
  }else{
    echo "Ocurrio un problema";
  }
});

$app->post('/documentos', function(Request $request, Response $response, array $args){
  //la direccion donda las vas a guardar
 $uploaddir = "../../public/";
 
 //carga del docuemento
 $uploadfile = $uploaddir . basename($_FILES['file']['name']);
 $error = $_FILES['file']['error'];
 $subido = false;
 $subido = copy($_FILES['file']['tmp_name'], $uploadfile);
  
 if($subido) { 
  echo "El file subio con exito"; 
 } else {
  echo "Se ha producido un error: ".$error;
 }
  
});

  