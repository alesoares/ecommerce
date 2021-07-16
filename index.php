<?php 

session_start();

require_once("vendor/autoload.php");/*SEMPRE VAI EXISTIR PARA TREZER AS DEPENDENCIAS DO COMPOSER*/

use \Slim\Slim;/*SÃO NAMESPACE; OU SEJA DENTRO DO VENDOR TENHO DEZENAS DE CLASSES. QUAL EU QUERO???*/

use \Hcode\Page;/*SÃO NAMESPACE; OU SEJA DENTRO DO VENDOR TENHO DEZENAS DE CLASSES. QUAL EU QUERO???*/

use \Hcode\PageAdmin;/*SÃO NAMESPACE; OU SEJA DENTRO DO VENDOR TENHO DEZENAS DE CLASSES. QUAL EU QUERO???*/

use \Hcode\Model\User;/*SÃO NAMESPACE; OU SEJA DENTRO DO VENDOR TENHO DEZENAS DE CLASSES. QUAL EU QUERO???*/

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

$app->run();/*RESPOSÁVEL POR LIGAR TUDO NO SITE*/

 ?>