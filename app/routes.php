<?php

use App\Controllers\MainController;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
	$r->addRoute('GET', '/', 'App\Controllers\ProjectController/showAction');
	$r->addRoute('GET', '/list', 'App\Controllers\ProjectController/listJsonAction');
	$r->addRoute('GET', '/skills', 'App\Controllers\ProjectController/skillsJsonAction');
	$r->addRoute('GET', '/stat', 'App\Controllers\ProjectController/statJsonAction');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
	$uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
	case FastRoute\Dispatcher::NOT_FOUND:

		echo render('template', [
			'title'		=> 'Ошибка 404',
			'tpl'	=> '_404'
		]);

		break;
	case FastRoute\Dispatcher::FOUND:
		$handler = $routeInfo[1];
		$vars = $routeInfo[2];

		list($class, $method) = explode("/", $handler, 2);
		echo call_user_func_array(array(new $class, $method), $vars);

		break;
}

