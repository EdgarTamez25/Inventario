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


//ver si existe el usuario
$app->post('/usuario', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  
  //Definir el sql
  $sth = $this->db->prepare('SELECT * FROM tusuario WHERE nomuser=:nomuser AND passuser=:password AND estatus="1"'); 
  
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('nomuser',   $datos['nomuser']);
  $sth -> bindParam('password',  $datos['password']);

  //Para ejecutar una consulta 
  $sth -> execute();
  $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});

//Editar usuarios
$app->put('/edituser/{cveuser}', function (Request $request, Response $response, array $args) {
  
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post

  //guardar el valor que esta recibiendo la ruta en una variables
  $cveuser = $request->getAttribute('cveuser');

  //cuando no sabes que valor es, se coloca =: cuando si sabes es solo el =
  $sth = $this -> db -> prepare('UPDATE tusuario SET  nomuser=:nomuser, corruser=:corruser, teluser=:teluser, direuser=:direuser, passuser=:passuser, fechcumuser=:fechcumuser, estatus=:estatus  WHERE cveuser=:cveuser ');

  $sth -> bindParam('nomuser',      $data['nomuser']);
  $sth -> bindParam('corruser',     $data['corruser']);
  $sth -> bindParam('teluser',      $data['teluser']);
  $sth -> bindParam('direuser',     $data['direuser']);
  $sth -> bindParam('passuser',     $data['passuser']);
  $sth -> bindParam('fechcumuser',  $data['fechcumuser']);
  $sth -> bindParam('estatus',      $data['estatus']);
  $sth -> bindParam('cveuser', $cveuser);
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }

});

$app->put('/edituser2/{idusuario}', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
  $idusuario = $request->getAttribute('idusuario');
  $sth = $this -> db -> prepare('UPDATE pendientes SET  nomuser=:nomuser WHERE nomuser=:nomuser2 ');
  $sth -> bindParam('nomuser',  $data['nomuser']);
  $sth -> bindParam('nomuser2',  $data['nomuser2']);
  if($sth -> execute()){
    echo "usuario modificada correctamente";
  }else{
    echo "No se pudo modifiar la orden";
  }

});


//agregar un usuario
$app->post('/newuser', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tusuario ( nomuser, passuser, estatus)
   VALUES ( :nomuser, :password, :estatus)'); 
  
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('nomuser',    $datos['nomuser']);
  $sth -> bindParam('password',   $datos['password']);
  $sth -> bindParam('estatus',   $datos['estatus']);

  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});


/*********************************************************************************************/
/* Fuente de ingreso */
//agregar fuente de ingreso
$app->post('/fuenteingreso', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tfuentesingreso ( tipo, descfue, cveuser)
   VALUES ( :tipo, :descfue, :cveuser)'); 
  
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('tipo',      $datos['tipo']);
  $sth -> bindParam('descfue',   $datos['descfue']);
  $sth -> bindParam('cveuser',   $datos['cveuser']);

  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});

//Actualizar fuente de ingreso
$app->put('/fuenteingreso', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
  $sth = $this -> db -> prepare('UPDATE tfuentesingreso 
    SET  tipo=:tipo, descfue=:descfue 
    WHERE cvefueing=:cvefueing ');
  $sth -> bindParam('tipo',  $data['tipo']);
  $sth -> bindParam('descfue',  $data['descfue']);
  $sth -> bindParam('cvefueing', $data['cvefueing']);
  $sth -> execute();
});


//Traer las fuentes de ingreso
$app->get('/fuenteingreso', function(Request $request, Response $response, array $args){
	//se crea el sql
	$sth = $this-> db -> prepare('SELECT * FROM tfuentesingreso');
	//Se ejecuta
	$sth -> execute();
    $fuente = $sth->fetchAll();
    echo json_encode($fuente);
});


$app->get('/fuenteingreso/{cvefueing}', function(Request $request, Response $response, array $args){
	$datos = $request -> getParsedBody();
    $cvefueing = $request->getAttribute('cvefueing');
	//se crea el sql
	$sth = $this-> db -> prepare('SELECT * FROM tfuentesingreso  WHERE cvefueing=:cvefueing');
	$sth -> bindParam('cvefueing', $cvefueing);
	//Se ejecuta
	$sth -> execute();
    $fuente = $sth->fetchAll();
    echo json_encode($fuente);
});



/********************************** Fuente de localidad **********************************/
//agregar localidades
$app->post('/localidad', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tlocalidad ( nommun, nomest, cveuser) 
    VALUES ( :nommun, :nomest, :cveuser)'); 
  
  //Defino las variables
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('nommun',   $datos['nommun']);
  $sth -> bindParam('nomest',   $datos['nomest']);
  $sth -> bindParam('cveuser',  $datos['cveuser']);

  //Para ejecutar una consulta 
  // $nuevousuario = $sth->fetchAll();
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
  
});

//Actualizar localidades
$app->put('/localidad', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
  $sth = $this -> db -> prepare('UPDATE tlocalidad SET  nommun=:nommun, nomest=:nomest  WHERE cvemun=:cvemun');
  $sth -> bindParam('nommun',  $data['nommun']);
  $sth -> bindParam('nomest',  $data['nomest']);
  $sth -> bindParam('cvemun',  $data['cvemun']);
  $sth -> execute();

});

//Traer las localidades
$app->get('/localidad', function(Request $request, Response $response, array $args){
	//se crea el sql
	$sth = $this-> db -> prepare('SELECT * FROM tlocalidad');
	//Se ejecuta
	$sth -> execute();
    $fuente = $sth->fetchAll();
    echo json_encode($fuente);
});

//Traer por id
$app->get('/localidad/{cvemun}', function(Request $request, Response $response, array $args){
	$datos = $request -> getParsedBody();
    $cvemun = $request->getAttribute('cvemun');
	//se crea el sql
	$sth = $this-> db -> prepare('SELECT * FROM tlocalidad  WHERE cvemun=:cvemun');
	$sth -> bindParam('cvemun', $cvemun);
	//Se ejecuta
	$sth -> execute();
    $localidad = $sth->fetchAll();
    echo json_encode($localidad);
});

/********************************** Fuente de regalos **********************************/

//regalos

$app->post('/regalos', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tregalo ( monini, monfin, descreg, catreg) VALUES ( :monini, :monfin, :descreg, :catreg)'); 
  //Defino las variables
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('monini',   $datos['monini']);
  $sth -> bindParam('monfin',   $datos['monfin']);
  $sth -> bindParam('descreg',  $datos['descreg']);
  $sth -> bindParam('catreg',   $datos['catreg']);
  //Para ejecutar una consulta 
  // $nuevousuario = $sth->fetchAll();
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});

// Actualizar Regalos
$app->put('/regalos', function (Request $request, Response $response, array $args) {
  
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
  $sth = $this -> db -> prepare('UPDATE tregalo 
    SET  monini=:monini, monfin=:monfin, descreg=:descreg, catreg=:catreg  
    WHERE cvereg=:cvereg ');
    $sth -> bindParam('monini',  $data['monini']);
    $sth -> bindParam('monfin',  $data['monfin']);
    $sth -> bindParam('descreg', $data['descreg']);
    $sth -> bindParam('catreg',  $data['catreg']);
    $sth -> bindParam('cvereg',  $data['cvereg']);
    $sth -> execute();
});

// //Traer los regalos
$app->get('/regalos', function(Request $request, Response $response, array $args){
	//se crea el sql
	$sth = $this-> db -> prepare('SELECT * FROM tregalo');
	//Se ejecuta
	$sth -> execute();
    $fuente = $sth->fetchAll();
    echo json_encode($fuente);
});

//Traer por id
$app->get('/regalos/{cvereg}', function(Request $request, Response $response, array $args){
	$datos = $request -> getParsedBody();
  $cvereg = $request->getAttribute('cvereg');
	//se crea el sql
	$sth = $this-> db -> prepare('SELECT * FROM tregalo  WHERE cvereg=:cvereg');
	$sth -> bindParam('cvereg', $cvereg);
	//Se ejecuta
	$sth -> execute();
    $regalos = $sth->fetchAll();
    echo json_encode($regalos);
});


/********************************** Donadores **********************************/

//Traer todos los donadores
$app->get('/donadores', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM tdonador');
  //Se ejecuta
  $sth -> execute();
    $donador = $sth->fetchAll();
    echo json_encode($donador);
});


//Buscar donador por id
$app->post('/donadores/fecha', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  
  //Definir el sql
  $sth = $this->db->prepare('SELECT  th.CVEDON, td.NOMDON, th.FECHA FROM thistorialdonador th INNER JOIN tdonador td
  ON th.CVEDON = td.CVEDON
  GROUP BY  th.CVEDON, th.FECHA, td.NOMDON'); 
  
  //Para ejecutar una consulta 
  $sth -> execute();
  $donadores = $sth->fetchAll();
    echo json_encode($donadores);
});

//Buscar donador por id
$app->post('/donadores', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  
  //Definir el sql
  $sth = $this->db->prepare('SELECT * FROM tdonador td 
  INNER JOIN tfuentesingreso tf ON td.CVEFUEING = tf.CVEFUEING
  INNER JOIN tlocalidad tl ON td.CVEMUN = tl.CVEMUN
  INNER JOIN tproyecto tp ON td.CVEPROY = tp.CVEPROY  
  INNER JOIN tusuario tu ON td.CVEUSER = tu.CVEUSER WHERE cvedon=:cvedon'); 
  
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('cvedon',   $datos['cvedon']);

  //Para ejecutar una consulta 
  $sth -> execute();
  $donadores = $sth->fetchAll();
    echo json_encode($donadores);
});


//agregar un donador
$app->post('/newdonador', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tdonador 
    ( cvefueing, nomdon, cordon, celdon, dirdon, teldon, feccumdon, horinilab, horfinlab, pagweb, cvemun, cp, cveproy, cveuser) 
    VALUES ( :cvefueing, :nomdon, :cordon, :celdon, :dirdon, :teldon, :feccumdon, :horinilab, :horfinlab, :pagweb, :cvemun, :cp, :cveproy, :cveuser)'); 
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('nomdon',      $datos['nomdon']);
  $sth -> bindParam('cvefueing',   $datos['cvefueing']);
  $sth -> bindParam('cordon',      $datos['cordon']);
  $sth -> bindParam('celdon',      $datos['celdon']);
  $sth -> bindParam('dirdon',      $datos['dirdon']);
  $sth -> bindParam('teldon',      $datos['teldon']);
  $sth -> bindParam('feccumdon',   $datos['feccumdon']);
  $sth -> bindParam('horinilab',   $datos['horinilab']);
  $sth -> bindParam('horfinlab',   $datos['horfinlab']);
  $sth -> bindParam('pagweb',      $datos['pagweb']);
  $sth -> bindParam('cvemun',      $datos['cvemun']);
  $sth -> bindParam('cp',          $datos['cp']);
  $sth -> bindParam('cveproy',     $datos['cveproy']);
  $sth -> bindParam('cveuser',     $datos['cveuser']);
  //Para ejecutar una consulta 
  // $nuevousuario = $sth->fetchAll();
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});

// Actualizar un dondaor
$app->put('/donadores', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody();

     $sth = $this -> db -> prepare('UPDATE tdonador 
      SET  cvefueing=:cvefueing, nomdon=:nomdon, cordon=:cordon, celdon=:celdon, dirdon=:dirdon, 
      teldon=:teldon, feccumdon=:feccumdon, horinilab=:horinilab, horfinlab=:horfinlab, pagweb=:pagweb, 
      cvemun=:cvemun, cp=:cp, cveproy=:cveproy
      WHERE cvedon=:cvedon ');

    $sth -> bindParam('cvedon',     $data['cvedon']);
    $sth -> bindParam('cvefueing',  $data['cvefueing']);
    $sth -> bindParam('nomdon',     $data['nomdon']);
    $sth -> bindParam('cordon',     $data['cordon']);
    $sth -> bindParam('celdon',     $data['celdon']);
    $sth -> bindParam('dirdon',     $data['dirdon']);
    $sth -> bindParam('teldon',     $data['teldon']);
    $sth -> bindParam('feccumdon',  $data['feccumdon']);
    $sth -> bindParam('horinilab',  $data['horinilab']);
    $sth -> bindParam('horfinlab',  $data['horfinlab']);
    $sth -> bindParam('pagweb',     $data['pagweb']);
    $sth -> bindParam('cvemun',     $data['cvemun']);
    $sth -> bindParam('cp',         $data['cp']);
    $sth -> bindParam('cveproy',    $data['cveproy']);
    $sth -> execute();


});

/********************************** Contactos **********************************/


//Traer todos los contactos
$app->get('/contactos', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM tcontacto tc INNER JOIN tdonador td ON tc.cvedon = td.cvedon');
  //Se ejecuta
  $sth -> execute();
    $contactos = $sth->fetchAll();
    echo json_encode($contactos);
});


////Buscar por id el contacto
$app->post('/contactos', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('SELECT * FROM tcontacto tc INNER JOIN tdonador td ON tc.cvedon = td.cvedon WHERE cvecont=:cvecont'); 
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('cvecont',   $datos['cvecont']);
  //Para ejecutar una consulta 
  $sth -> execute();
  $contactos = $sth->fetchAll();
    echo json_encode($contactos);
});


//Agregar un donador
$app->post('/newcontacto', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tcontacto 
    ( cvedon, nomcont, tipocont, fechcumcont, corrcont, telcont, cveuser) 
    VALUES ( :cvedon, :nomcont, :tipocont, :fechcumcont, :corrcont, :telcont, :cveuser)'); 
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('cvedon',       $datos['cvedon']);
  $sth -> bindParam('nomcont',      $datos['nomcont']);
  $sth -> bindParam('tipocont',     $datos['tipocont']);
  $sth -> bindParam('fechcumcont',  $datos['fechcumcont']);
  $sth -> bindParam('corrcont',     $datos['corrcont']);
  $sth -> bindParam('telcont',      $datos['telcont']);
  $sth -> bindParam('cveuser',      $datos['cveuser']);
  //Para ejecutar una consulta 
  // $nuevousuario = $sth->fetchAll();
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});

// Actualizar un contacto
$app->put('/contactos', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
     $sth = $this -> db -> prepare('UPDATE tcontacto 
      SET  cvedon=:cvedon, nomcont=:nomcont, tipocont=:tipocont, fechcumcont=:fechcumcont, corrcont=:corrcont, telcont=:telcont WHERE cvecont=:cvecont ');

      $sth -> bindParam('cvecont',     $data['cvecont']);
      $sth -> bindParam('cvedon',      $data['cvedon']);
      $sth -> bindParam('nomcont',     $data['nomcont']);
      $sth -> bindParam('tipocont',    $data['tipocont']);
      $sth -> bindParam('fechcumcont', $data['fechcumcont']);
      $sth -> bindParam('corrcont',    $data['corrcont']);
      $sth -> bindParam('telcont',     $data['telcont']);
      $sth -> execute();

});


/********************************** Proyectos **********************************/


//Traer todos los proyectos
$app->get('/proyectos', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM tproyecto');
  //Se ejecuta
  $sth -> execute();
    $proyectos = $sth->fetchAll();
    echo json_encode($proyectos);
});

// Buscar proyecto por id
$app->post('/proyectos', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('SELECT tp.CVEPROY, tp.NOMPROY, tp.PRES ,tp.VIGENCIA, tp.DESPROY FROM tproyecto tp WHERE tp.CVEPROY =:cveproy'); 
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('cveproy',   $datos['cveproy']);
  //Para ejecutar una consulta 
  $sth -> execute();
  $proyectos = $sth->fetchAll();
    echo json_encode($proyectos);
});

$app->post('/proyectos/donadores', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('SELECT DISTINCT td.NOMDON FROM thistorialdonador th INNER JOIN tdonador td ON th.CVEDON = td.CVEDON WHERE th.CVEPROY=:cveproy'); 
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('cveproy',   $datos['cveproy']);
  //Para ejecutar una consulta 
  $sth -> execute();
  $proyectos = $sth->fetchAll();
    echo json_encode($proyectos);
});

$app->post('/proyectos/factura', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('SELECT * FROM tfactura WHERE cveproy=:cveproy'); 
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('cveproy',   $datos['cveproy']);
  //Para ejecutar una consulta 
  $sth -> execute();
  $proyectos = $sth->fetchAll();
    echo json_encode($proyectos);
});

$app->post('/proyectos/comprobante', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('SELECT tc.CVECOMP, td.NOMDON, tc.COMP FROM tcomprobante tc
INNER JOIN tdonador td ON tc.CVEDON = td.CVEDON
WHERE tc.cveproy=:cveproy'); 
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('cveproy',   $datos['cveproy']);
  //Para ejecutar una consulta 
  $sth -> execute();
  $proyectos = $sth->fetchAll();
    echo json_encode($proyectos);
});

$app->post('/proyectos/desglose', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('SELECT DISTINCT * FROM tdesglose WHERE cveproy=:cveproy'); 
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('cveproy',   $datos['cveproy']);
  //Para ejecutar una consulta 
  $sth -> execute();
  $proyectos = $sth->fetchAll();
    echo json_encode($proyectos);
});

//buscar donadores por usuario
$app->post('/newproyecto', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tproyecto 
    ( nomproy, vigencia, desproy, proyact, cveuser, pres ) 
    VALUES (  :nomproy, :vigencia, :desproy, :proyact, :cveuser, :pres)'); 
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('nomproy',  $datos['nomproy']);
  $sth -> bindParam('vigencia', $datos['vigencia']);
  $sth -> bindParam('desproy',  $datos['desproy']);
  $sth -> bindParam('proyact',  $datos['proyact']);
  $sth -> bindParam('cveuser',  $datos['cveuser']);
  $sth -> bindParam('pres',     $datos['pres']);
  //Para ejecutar una consulta 
  // $nuevousuario = $sth->fetchAll();
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});

// Actualizar un proyecto
$app->put('/proyectos', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
    $sth = $this -> db -> prepare('UPDATE tproyecto 
      SET  nomproy=:nomproy, pres=:pres, vigencia=:vigencia, desproy=:desproy, proyact=:proyact WHERE  cveproy=:cveproy ');

    $sth -> bindParam('cveproy',   $data['cveproy']);
    $sth -> bindParam('nomproy',   $data['nomproy']);
    $sth -> bindParam('pres',      $data['pres']);
    $sth -> bindParam('vigencia',  $data['vigencia']);
    $sth -> bindParam('desproy',   $data['desproy']);
    $sth -> bindParam('proyact',   $data['proyact']);
    $sth -> execute();

});

$app->put('/proyecto/estatus', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
    $sth = $this -> db -> prepare('UPDATE tproyecto 
      SET  proyact=:proyact WHERE  cveproy=:cveproy ');

    $sth -> bindParam('cveproy',   $data['cveproy']);
    $sth -> bindParam('proyact',   $data['proyact']);
    $sth -> execute();

});


/********************************** Comprobantes **********************************/

//Traer todos los comprobantes
$app->get('/comprobantes', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM tcomprobante');
  //Se ejecuta
  $sth -> execute();
    $compronates = $sth->fetchAll();
    echo json_encode($compronates);
});

$app->delete('/proyectos/comprobantes/{cvecomp}', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
  //guardar el valor que esta recibiendo la ruta en una variables
  $cvecomp = $request->getAttribute('cvecomp');
  //cuando no sabes que valor es, se coloca =: cuando si sabes es solo el =
  $sth = $this -> db -> prepare('DELETE FROM tcomprobante WHERE cvecomp=:cvecomp');
  $sth -> bindParam('cvecomp', $cvecomp);
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});


//Traer todos los comprobantes
$app->get('/proyectos/comprobante/{cvecomp}', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  $cvecomp = $request->getAttribute('cvecomp');
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM tcomprobante tc INNER JOIN tdonador td ON tc.CVEDON = td.CVEDON INNER JOIN tproyecto tp ON tp.CVEPROY = tc.CVEPROY WHERE tc.cvecomp=:cvecomp');
  //Se ejecuta
  $sth -> bindParam('cvecomp', $cvecomp);

  $sth -> execute();
    $compronates = $sth->fetchAll();
    echo json_encode($compronates);
});

//Buscar un comprobante por id
$app->post('/comprobantes', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('SELECT * FROM tcomprobante WHERE cvecomp=:cvecomp'); 
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('cvecomp',   $datos['cvecomp']);
  //Para ejecutar una consulta 
  $sth -> execute();
  $proyectos = $sth->fetchAll();
    echo json_encode($proyectos);
});

//Agregar un comprobante
$app->post('/newcomprobante', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tcomprobante ( cvedon, cveproy, comp, cveuser) 
    VALUES (  :cvedon, :cveproy, :comp, :cveuser)'); 
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('cvedon',   $datos['cvedon']);
  $sth -> bindParam('cveproy',  $datos['cveproy']);
  $sth -> bindParam('comp',     $datos['comp']);
  $sth -> bindParam('cveuser',  $datos['cveuser']);
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});

// Actualizar un comprobante
$app->put('/comprobantes', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
    $sth = $this -> db -> prepare('UPDATE tcomprobante 
    SET comp=:comp
    WHERE cvecomp=:cvecomp AND cveproy=:cveproy AND cvedon=:cvedon');

    $sth -> bindParam('cvedon',    $data['cvedon']);
    $sth -> bindParam('cvecomp',   $data['cvecomp']);
    $sth -> bindParam('cveproy',   $data['cveproy']);
    $sth -> bindParam('comp',      $data['comp']);
    $sth -> execute();
});


/********************************** Comprobantes **********************************/
//Traer todos los cultivos
$app->get('/cultivos', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT tc.CVECULT, td.NOMDON, tr.DESCREG, tc.DESCULT, tc.FECHCULT, tc.CVEUSER FROM tcultivo tc
    INNER JOIN tdonador td ON td.CVEDON = tc.CVEDON
    INNER JOIN tregalo tr ON tr.CVEREG = tc.CVEREG');
  //Se ejecuta
  $sth -> execute();
    $cultivos = $sth->fetchAll();
    echo json_encode($cultivos);
});

//Buscar un cultivo por id
$app->post('/cultivo', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('SELECT DESCREG FROM tregalo
WHERE (SELECT SUM(CANTDONA) AS donativo FROM thistorialdonador WHERE CVEDON=:cvedon AND YEAR(FECHA)=:anio) BETWEEN monini and monfin'); 
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('cvedon',   $datos['cvedon']);
  $sth -> bindParam('anio',     $datos['anio']);
  //Para ejecutar una consulta 
  $sth -> execute();
  $cultivos = $sth->fetchAll();
    echo json_encode($cultivos);
});


//Buscar un cultivo por id
$app->post('/cultivos', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('SELECT * FROM tcultivo WHERE cvecult=:cvecult'); 
  //aqui es donde se le mandan los parametros a la query
  $sth -> bindParam('cvecult',   $datos['cvecult']);
  //Para ejecutar una consulta 
  $sth -> execute();
  $cultivos = $sth->fetchAll();
    echo json_encode($cultivos);
});

//Agregar un cultivo
$app->post('/newcultivo', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tcultivo ( cvedon, descult, cvereg, fechcult, cveuser) 
    VALUES ( :cvedon, :descult, :cvereg, :fechcult, :cveuser)'); 
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('cvedon',   $datos['cvedon']);
  $sth -> bindParam('descult',  $datos['descult']);
  $sth -> bindParam('cvereg',   $datos['cvereg']);
  $sth -> bindParam('fechcult', $datos['fechcult']);
  $sth -> bindParam('cveuser',  $datos['cveuser']);
  //Para ejecutar una consultsa 
  // $nuevousuario = $sth->fetchAll();
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});

// Actualizar un cultivo
$app->put('/cultivos', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); 
    $sth = $this -> db -> prepare('UPDATE tcultivo 
      SET  cvedon=:cvedon, descult=:descult, cvereg=:cvereg, fechcult=:fechcult
      WHERE cvecult=:cvecult ');

    $sth -> bindParam('cvedon',    $data['cvedon']);
    $sth -> bindParam('descult',   $data['descult']);
    $sth -> bindParam('cvereg',    $data['cvereg']);
    $sth -> bindParam('fechcult',  $data['fechcult']);
    $sth -> bindParam('cvecult',   $data['cvecult']);
    $sth -> execute();

});

/********************************** Cumpleañios **********************************/


// Traer solo el mes y el año
//SELECT cvecump, cveacum, CONCAT(MONTH(FECHA) , "-" , DAY(FECHA)) AS 'Cumpleanios', estatus FROM tcumpleanios;


//Todos los cumpleaños
$app->get('/cumpleaniosu', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT tc.NOMCONT AS cveacum, CONCAT(MONTHNAME(FECHCUMCONT) , "-" , DAY(FECHCUMCONT)) AS "Cumpleanios", CORRCONT  AS "correo" FROM tcontacto tc WHERE FECHCUMCONT > 0 ORDER BY DAY(FECHCUMCONT) AND MONTHNAME(FECHCUMCONT)');
  //Se ejecuta
  $sth -> execute();
    $cumpleanios = $sth->fetchAll();
    echo json_encode($cumpleanios);
});

//Todos los cumpleaños
$app->get('/cumpleaniosc', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT tu.NOMUSER AS cveacum, CONCAT(MONTHNAME(FECHCUMUSER) , "-" , DAY(FECHCUMUSER)) AS "Cumpleanios", CORRUSER AS "correo" FROM tusuario tu WHERE FECHCUMUSER > 0  ORDER BY DAY(FECHCUMUSER) AND MONTHNAME(FECHCUMUSER)');
  //Se ejecuta
  $sth -> execute();
    $cumpleanios = $sth->fetchAll();
    echo json_encode($cumpleanios);
});

//Todos los cumpleaños
$app->get('/cumpleaniosd', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT td.NOMDON AS cveacum,CONCAT(MONTHNAME(FECCUMDON) , "-" , DAY(FECCUMDON)) AS "Cumpleanios", CORDON AS "correo" FROM tdonador td WHERE FECCUMDON > 0 ORDER BY DAY(FECCUMDON) AND MONTHNAME(FECCUMDON)');
  //Se ejecuta
  $sth -> execute();
    $cumpleanios = $sth->fetchAll();
    echo json_encode($cumpleanios);
});




// Actualizar los cunpleanios
$app->put('/cumpleanios', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
  //cuando no sabes que valor es, se coloca =: cuando si sabes es solo el =
  $sth = $this -> db -> prepare('UPDATE tcumpleanios 
    SET  cveacum=:cveacum, feli=:feli, fecha=:fecha, estatus=:estatus
    WHERE cvecump=:cvecump');
  $sth -> bindParam('cveacum',   $data['cveacum']);
  $sth -> bindParam('feli',      $data['feli']);
  $sth -> bindParam('fecha',     $data['fecha']);
  $sth -> bindParam('estatus',   $data['estatus']);
  $sth -> bindParam('cvecump',   $data['cvecump']);
  
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }

});


/********************************** Desgloce **********************************/

//Traer el desgloce por proyecto
$app->post('/desglose', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM tdesglose td INNER JOIN tproyecto tp ON td.cveproy = tp.cveproy WHERE td.cveproy=:cveproy');
  $sth -> bindParam('cveproy',   $datos['cveproy']);

  //Se ejecuta
  $sth -> execute();
    $desglose = $sth->fetchAll();
    echo json_encode($desglose);
});

$app->get('/proyectos/desglose/{cvedesglose}', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  $cvedesglose = $request->getAttribute('cvedesglose');
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM tdesglose td INNER JOIN tproyecto tp ON td.cveproy = tp.cveproy WHERE  td.cvedesglose=:cvedesglose');
  $sth -> bindParam('cvedesglose', $cvedesglose);
  //Se ejecuta
  $sth -> execute();
    $facturas = $sth->fetchAll();
    echo json_encode($facturas);
});


// agregar un nuevo desgloce
$app->post('/newdesglose', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tdesglose ( cveproy, desdes, mon, cveuser) 
    VALUES (  :cveproy, :desdes, :mon, :cveuser)'); 
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('cveproy', $datos['cveproy']);
  $sth -> bindParam('desdes',     $datos['desdes']);
  $sth -> bindParam('mon',    $datos['mon']);
  $sth -> bindParam('cveuser',  $datos['cveuser']);
  //Para ejecutar una consultsa 
  // $nuevousuario = $sth->fetchAll();
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});


//  Actualizar una factura
$app->put('/desglose', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); 
    $sth = $this -> db -> prepare('UPDATE tdesglose 
      SET mon=:mon, desdes=:desdes WHERE cvedesglose=:cvedesglose AND cveproy=:cveproy');

    $sth -> bindParam('cvedesglose',  $data['cvedesglose']);
    $sth -> bindParam('cveproy',      $data['cveproy']);
    $sth -> bindParam('mon',          $data['mon']);
    $sth -> bindParam('desdes',       $data['desdes']);
    $sth -> execute();

});

$app->delete('/desglose/{cvedesglose}', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
  //guardar el valor que esta recibiendo la ruta en una variables
  $cvedesglose = $request->getAttribute('cvedesglose');
  //cuando no sabes que valor es, se coloca =: cuando si sabes es solo el =
  $sth = $this -> db -> prepare('DELETE FROM tdesglose WHERE cvedesglose=:cvedesglose');
  $sth -> bindParam('cvedesglose', $cvedesglose);
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});



/********************************** Facturas **********************************/
//Traer las facturas por proyecto
$app->post('/facturas', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM tfactura WHERE cveproy=:cveproy');
  
  $sth -> bindParam('cveproy', $datos['cveproy']);
  //Se ejecuta
  $sth -> execute();
    $facturas = $sth->fetchAll();
    echo json_encode($facturas);
});

$app->get('/proyectos/factura/{cvefac}', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  $cvefac = $request->getAttribute('cvefac');
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM tfactura WHERE cvefac=:cvefac');
  $sth -> bindParam('cvefac', $cvefac);
  //Se ejecuta
  $sth -> execute();
    $facturas = $sth->fetchAll();
    echo json_encode($facturas);
});


//Agregar una factura
$app->post('/newfactura', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tfactura ( nompro, cveproy, feccap, conce, monfact, razosoc, numfact) 
    VALUES ( :nompro, :cveproy, :feccap, :conce, :monfact, :razosoc, :numfact)'); 
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('nompro',   $datos['nompro']);
  $sth -> bindParam('cveproy',  $datos['cveproy']);
  $sth -> bindParam('feccap',   $datos['feccap']);
  $sth -> bindParam('conce',    $datos['conce']);
  $sth -> bindParam('monfact',  $datos['monfact']);
  $sth -> bindParam('razosoc',  $datos['razosoc']);
  $sth -> bindParam('numfact',  $datos['numfact']);
  //Para ejecutar una consultsa 
  // $nuevousuario = $sth->fetchAll();
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});

//  Actualizar una factura
$app->put('/factura', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); 
    $sth = $this -> db -> prepare('UPDATE tfactura 
      SET cvedon=:cvedon, cveproy=:cveproy, cvefac=:cvefac, conce=:conce, razosoc=:razosoc, monfact=:monfact WHERE cvefac=:cvefac  AND cveproy=:cveproy AND cvedon=:cvedon');

    $sth -> bindParam('cvefac',    $data['cvefac']);
    $sth -> bindParam('cveproy',   $data['cveproy']);
    $sth -> bindParam('cvedon',    $data['cvedon']); 
    $sth -> bindParam('feccap',    $data['feccap']);
    $sth -> bindParam('conce',     $data['conce']);
    $sth -> bindParam('monfact',   $data['monfact']);
    $sth -> bindParam('razosoc',   $data['razosoc']);
    $sth -> execute();

});

$app->delete('/factura/{cvefac}', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
  //guardar el valor que esta recibiendo la ruta en una variables
  $cvefac = $request->getAttribute('cvefac');
  //cuando no sabes que valor es, se coloca =: cuando si sabes es solo el =
  $sth = $this -> db -> prepare('DELETE FROM tfactura WHERE cvefac=:cvefac');
  $sth -> bindParam('cvefac', $cvefac);
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "No se pudo modifiar la orden";
  }
});



/********************************** Historial del donador **********************************/
//Traer el historial por donador
$app->get('/historial', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT SUM(CANTDONA) AS donacion, td.NOMDON FROM thistorialdonador th
  INNER JOIN tdonador td ON th.CVEDON = td.CVEDON
  GROUP BY th.CVEDON ');
  
  //Se ejecuta
  $sth -> execute();
    $historial = $sth->fetchAll();
    echo json_encode($historial);
});


//Agregar un historial
$app->post('/newhistorial', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  thistorialdonador ( cvedon, cveproy, cantdona, fecha, cveuser) 
    VALUES ( :cvedon, :cveproy, :cantdona, :fecha, :cveuser)'); 
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('cvedon',   $datos['cvedon']);
  $sth -> bindParam('cveproy',  $datos['cveproy']);
  $sth -> bindParam('cantdona', $datos['cantdona']);
  $sth -> bindParam('fecha',    $datos['fecha']);
  $sth -> bindParam('cveuser',  $datos['cveuser']);
  //Para ejecutar una consultsa 
  // $nuevousuario = $sth->fetchAll();
  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});

//  Actualizar un historial
$app->put('/historial', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); 
    $sth = $this -> db -> prepare('UPDATE thistorialdonador 
      SET cvedon=:cvedon, cveproy=:cveproy, cvehis=:cvehis fecha=:fecha, cantdona=:cantdona
       WHERE cvehis=:cvehis  AND cveproy=:cveproy AND cvedon=:cvedon');

    $sth -> bindParam('cvehis',   $data['cvehis']);
    $sth -> bindParam('cveproy',  $data['cveproy']);
    $sth -> bindParam('cvedon',   $data['cvedon']); 
    $sth -> bindParam('fecha',    $data['fecha']);
    $sth -> bindParam('cantdona', $data['cantdona']);
    $sth -> execute();
});


/********************************** Usuarios **********************************/
//Traer todos los usuarios
$app->get('/usuarios', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT CVEUSER, NOMUSER, DIREUSER, CORRUSER, TELUSER, CONCAT(MONTHNAME(FECHCUMUSER) , "-" , DAY(FECHCUMUSER)) AS "CUMPLE", ESTATUS, PASSUSER, FECHCUMUSER FROM tusuario ');
  
  //Se ejecuta
  $sth -> execute();
    $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});

//Traer un solo usuario
$app->post('/usuarios', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM tusuario WHERE nomuser=:nomuser');
    $sth -> bindParam('nomuser',   $datos['nomuser']);
  //Se ejecuta
  $sth -> execute();
    $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});


//  Actualizar un historial
$app->put('/usuario', function (Request $request, Response $response, array $args) {
  $data = $request -> getParsedBody(); 

    $sth = $this -> db -> prepare('UPDATE tusuario 
      SET nomuser=:nomuser, direuser=:direuser, corruser=:corruser, cveuser=:cveuser, passuser=:passuser, teluser=:teluser, fechcumuser=:fechcumuser
       WHERE cveuser=:cveuser');

    $sth -> bindParam('corruser',    $data['corruser']);
    $sth -> bindParam('cveuser',     $data['cveuser']);
    $sth -> bindParam('direuser',    $data['direuser']);
    $sth -> bindParam('nomuser',     $data['nomuser']); 
    $sth -> bindParam('passuser',    $data['passuser']);
    $sth -> bindParam('teluser',     $data['teluser']);
    $sth -> bindParam('fechcumuser', $data['fechcumuser']);
    $sth -> execute();
    echo "SI";

});



/********************************** Graficas **********************************/
//Proyectos
$app->post('/graficas/proyectos/inicial', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT SUM(th.CANTDONA) AS DONATIVO, tp.NOMPROY FROM thistorialdonador th
    INNER JOIN tproyecto tp ON tp.CVEPROY = th.CVEPROY
    INNER JOIN tdonador td ON td.CVEDON = th.CVEDON
    WHERE YEAR(th.FECHA) =:anio
    GROUP BY tp.NOMPROY');
    $sth -> bindParam('anio',    $datos['anio']);

  //Se ejecuta
  $sth -> execute();
    $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});

$app->post('/graficas/proyectos/donador', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT SUM(CANTDONA) AS DONATIVO, tp.NOMPROY, td.NOMDON FROM thistorialdonador th
    INNER JOIN tproyecto tp ON th.CVEPROY = tp.CVEPROY
    INNER JOIN tdonador td ON td.CVEDON = th.CVEDON
    WHERE YEAR(th.FECHA) =:anio 
    AND td.NOMDON =:nomdon
    GROUP BY tp.NOMPROY, td.NOMDON');
    $sth -> bindParam('anio',    $datos['anio']);
    $sth -> bindParam('nomdon',    $datos['nomdon']);

  //Se ejecuta
  $sth -> execute();
    $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});


$app->post('/graficas/proyectos', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT td.NOMDON, SUM(th.CANTDONA) AS DONATIVO, tp.NOMPROY FROM thistorialdonador th
    INNER JOIN tproyecto tp ON th.CVEPROY = tp.CVEPROY
    INNER JOIN tdonador td ON th.CVEDON = td.CVEDON
    WHERE tp.NOMPROY =:nomproy AND YEAR(th.FECHA) =:anio  GROUP BY th.CVEPROY, th.CVEDON');
    $sth -> bindParam('anio',    $datos['anio']);
    $sth -> bindParam('nomproy',    $datos['nomproy']);

  //Se ejecuta
  $sth -> execute();
    $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});



$app->post('/graficas/proyectos/donadores', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT SUM(CANTDONA) AS DONATIVO, th.NOMPROY, th.NOMDON FROM thistorialdonador th
    INNER JOIN tproyecto tp ON th.CVEPROY = tp.CVEPROY
    INNER JOIN tdonador td ON td.CVEDON = th.CVEDON
    WHERE YEAR(FECHA) =:anio 
    GROUP BY th.CVEPROY');
    $sth -> bindParam('anio',    $datos['anio']);

  //Se ejecuta
  $sth -> execute();
    $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});

$app->post('/historico/donadores', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM thistorialdonador th
    INNER JOIN tdonador td ON td.CVEDON = th.CVEDON
    INNER JOIN tproyecto tp ON tp.CVEPROY = th.CVEPROY');
  //Se ejecuta
  $sth -> execute();
    $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});

$app->post('/historico/donadores2', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT * FROM thistorialdonador th
    INNER JOIN tdonador td ON th.CVEDON = td.CVEDON
    INNER JOIN tproyecto tp ON th.CVEPROY = tp.CVEPROY
    WHERE td.NOMDON=:nomdon');

    $sth -> bindParam('nomdon',    $datos['nomdon']);

  //Se ejecuta
  $sth -> execute();
    $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});

$app->post('/graficas/fuentes/todas', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT SUM(th.CANTDONA) AS DONATIVO, tf.TIPO FROM tfuentesingreso tf
    INNER JOIN tdonador td ON td.CVEFUEING = tf.CVEFUEING
    INNER JOIN thistorialdonador th ON td.CVEDON = th.CVEDON
    GROUP BY tf.TIPO');
    // $sth -> bindParam('anio',    $datos['anio']);
    // $sth -> bindParam('nomdon',    $datos['nomdon']);

  //Se ejecuta
  $sth -> execute();
    $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});


$app->post('/graficas/fuentes', function(Request $request, Response $response, array $args){
  //recupera los datos enviados
  $datos = $request -> getParsedBody(); 
  //se crea el sql
  $sth = $this-> db -> prepare('SELECT SUM(th.CANTDONA) AS DONATIVO, tf.TIPO FROM tfuentesingreso tf
    INNER JOIN tdonador td ON td.CVEFUEING = tf.CVEFUEING
    INNER JOIN thistorialdonador th ON td.CVEDON = th.CVEDON
    WHERE YEAR(th.FECHA) =:anio
    GROUP BY tf.TIPO');
    $sth -> bindParam('anio',    $datos['anio']);

  //Se ejecuta
  $sth -> execute();
    $usuarios = $sth->fetchAll();
    echo json_encode($usuarios);
});

//api para subir archvio
$app->post('/documentos', function(Request $request, Response $response, array $args){
  //la direccion donda las vas a guardar
 $uploaddir = "../../documentos/";
 
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


/************************************* Pendientes ******************************************************/
//Agregar pendietes
$app->post('/pendientes', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $datos = $request -> getParsedBody();
  
  //Definir el sql
  $sth = $this->db->prepare('INSERT INTO  tpendientes ( cveuser, fechlim, descpen, estatusp)
   VALUES ( :cveuser, :fechlim, :descpen, :estatusp)'); 
  
  //primer columna nombre del parametro, la y segunda es el valor ose ala variable
  //pero solo de los valores que no conozco
  $sth -> bindParam('cveuser',    $datos['cveuser']);
  $sth -> bindParam('fechlim',    $datos['fechlim']);
  $sth -> bindParam('descpen',    $datos['descpen']);
  $sth -> bindParam('estatusp',   $datos['estatusp']);

  if($sth -> execute()){
    echo "SI";
  }else{
    echo "NO";
  }
});

//traer todos los pendientes
$app->get('/pendientes/{cveuser}', function (Request $request, Response $response, array $args) {
   //recupera los datos enviados
  $cveuser = $request->getAttribute('cveuser');
  
  //Definir el sql
  $sth = $this->db->prepare('SELECT * FROM tpendientes WHERE estatusp="P" AND cveuser=:cveuser ORDER BY fechlim'); 
  $sth -> bindParam('cveuser',   $cveuser);

  
$sth -> execute();
    $pendientes = $sth->fetchAll();
    echo json_encode($pendientes);
});

//Acambiar estatus
$app->put('/pendientes', function (Request $request, Response $response, array $args) {
  
  $data = $request -> getParsedBody(); //Obtener parameto //cuando me mandan esn post
  $sth = $this -> db -> prepare('UPDATE tpendientes 
      SET  estatusp="T"
      WHERE cvepen=:cvepen');
      $sth -> bindParam('cvepen',  $data['cvepen']);
      $sth -> execute();

});




