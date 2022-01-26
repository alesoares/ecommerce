<?php 

session_start();

require_once("vendor/autoload.php");/*SEMPRE VAI EXISTIR PARA TREZER AS DEPENDENCIAS DO COMPOSER*/

use \Slim\Slim;/*SÃO NAMESPACE; OU SEJA DENTRO DO VENDOR TENHO DEZENAS DE CLASSES. QUAL EU QUERO???*/

use \Hcode\Page;/*SÃO NAMESPACE; OU SEJA DENTRO DO VENDOR TENHO DEZENAS DE CLASSES. QUAL EU QUERO???*/

use \Hcode\PageAdmin;/*SÃO NAMESPACE; OU SEJA DENTRO DO VENDOR TENHO DEZENAS DE CLASSES. QUAL EU QUERO???*/

use \Hcode\Model\User;/*SÃO NAMESPACE; OU SEJA DENTRO DO VENDOR TENHO DEZENAS DE CLASSES. QUAL EU QUERO???*/

use \Hcode\Model\Category;/*SÃO NAMESPACE; OU SEJA DENTRO DO VENDOR TENHO DEZENAS DE CLASSES. QUAL EU QUERO???*/

/*ARQUIVOS DE ROTAS PARA O "SEO"; OU MOTORES DE BUSCA EM SITES*/

$app = new \Slim\Slim();/*POR CAUSA DAS ROTAS, PARA FACILITAR, O "SEO" AGORA BUSCA POR ROTAS, POR CONTA DE RANQUEAMENTO DE BUSCA*/

$app->config('debug', true);
/*DAQUI PARA CIMA E SEMPRE O QUE VAMOS PRECISAR PARA CRIAR NOSSAS PAGINAS*/

$app->get('/', function() {/*QUAL A ROTA QUE ESTOU CHAMANDO*/

	$page = new Page();

	$page->setTpl( "index" );
    
});

$app->get('/admin', function() {/*QUAL A ROTA QUE ESTOU CHAMANDO*/

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl( "index" );
    
});

$app->get('/admin/login', function() {/*QUAL A ROTA QUE ESTOU CHAMANDO*/

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl( "login" );
    
});

$app->post('/admin/login', function() {

	User::login( $_POST['login'], $_POST['password']);

	header( "Location: /admin");

	exit;
});

$app->get('/admin/logout', function() {

	User::logout();

	header( "Location: /admin/login");

	exit;
});

$app->get('/admin/users', function(){

	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl( "users", array(
		"users"=>$users
	));
});

$app->get('/admin/users/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl( "users-create" );
});

$app->get('/admin/users/:iduser/delete', function( $iduser ){

	User::verifyLogin();

	$user = new User();
 
    $user->get((int)$iduser);

    $user->delete();

    header("Location: /admin/users");
	exit();

});

$app->get('/admin/users/:iduser', function( $iduser ){

	User::verifyLogin();

	$user = new User();
 
    $user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl( "users-update", array(
		"user"=>$user->getValues()
	));
});

$app->post('/admin/users/create', function(){

	User::verifyLogin();

	$user = new User();

	$_POST['inadmin'] = (isset( $_POST['inadmin']))?1:0;

	$user->setData($_POST);

	$user->save();

	var_dump($user);

	header("Location: /admin/users");
	exit();
});

$app->post('/admin/users/:iduser', function( $iduser ){

	User::verifyLogin();

	$user = new User();

	$_POST['inadmin'] = (isset( $_POST['inadmin']))?1:0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");
	exit();

});

$app->get("/admin/forgot", function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl( "forgot" );

});

$app->post("/admin/forgot", function(){

	$user = User::getForgot($_POST['email']);

	header("Location: /admin/forgot/sent");
	exit;

});

$app->get("/admin/forgot/sent", function(){ 

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl( "forgot-sent" );

});

$app->get("/admin/forgot/reset", function(){ 

	$user = User::validForgotDecrypt($_GET['code']);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl( "forgot-reset", array(
		"name"=>$user['desperson'],
		"code"=>$_GET['code']
	));

});


$app->post("/admin/forgot/reset", function(){ 

	$forgot = User::validForgotDecrypt($_POST['code']);

	User::setFogotUsed($forgot['idrecovery']);

	$user = new User();

	$user->get((int)$forgot['iduser']);

	$password = password_hash($_POST['password'], PASSWORD_DEFAULT, [
		"cost"=>12 /*Quanto maior o número melhor será a criptografia mas pode causar até queda da aplicação*/
	]);

	$user->setPassword($password);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl( "forgot-reset-success" );

});

$app->get("/admin/categories", function(){ 

	User::verifyLogin();

	$categories = Category::listAll();

	$page = new PageAdmin();

	$page->setTpl( "categories", [
		"categories"=>$categories
	]);

});

$app->get("/admin/categories/create", function(){ 

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl( "categories-create" );

});

$app->post("/admin/categories/create", function(){ 

	User::verifyLogin();

	$category = new Category();

	$category->setData( $_POST );

	$category->save();

	header("Location: /admin/categories" );
	exit;

});

$app->get( "/admin/categories/:idcategory/delete", function( $idcategory ){ 

	User::verifyLogin();

	$category = new Category();

	$category->get( ( int )$idcategory );

	$category->delete();

	header("Location: /admin/categories" );
	exit;

});

$app->get( "/admin/categories/:idcategory", function( $idcategory ){ 

	User::verifyLogin();

	$category = new Category();

	$category->get( ( int )$idcategory );

	$page = new PageAdmin();

	$page->setTpl( "categories-update", [
		"category"=>$category->getValues()
	]);

	//header("Location: /admin/categories" );
	//exit;

});

$app->post( "/admin/categories/:idcategory", function( $idcategory ){ 

	User::verifyLogin();

	$category = new Category();

	$category->get( ( int )$idcategory );

	$category->setData( $_POST );

	$category->save();

	header("Location: /admin/categories" );
	exit;

});

































$app->run();/*RESPOSÁVEL POR LIGAR TUDO NO SITE*/

 ?>