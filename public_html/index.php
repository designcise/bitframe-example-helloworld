<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Server\MiddlewareInterface;
use \Psr\Http\Server\RequestHandlerInterface as Handler;

$app = new \BitFrame\Application();

$app->addMiddleware([
    // response emitter
    // @see https://www.bitframephp.com/middleware/response-emitter
	\BitFrame\Message\DiactorosResponseEmitter::class,
	
    // custom middleware to output (string) "Hello World!"
    // @see https://www.bitframephp.com/doc/application/add-middleware
	new class implements MiddlewareInterface {
		public function process(Request $request, Handler $handler): Response 
        {
            $response = $handler->handle($request);
            $response->getBody()->write("Hello World!");

            return $response;
        }
    }
]);

// run app
$app->run();