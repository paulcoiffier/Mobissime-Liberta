<?php

require '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use App\Controller;
use App\Listeners;

$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../src/app.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new App\Listeners\ContentLengthListener());
//$dispatcher->addSubscriber(new App\GoogleListener());

$framework = new App\Framework($dispatcher, $matcher, $resolver);
$response = $framework->handle($request);

$response->send();

?>