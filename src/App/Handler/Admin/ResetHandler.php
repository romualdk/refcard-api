<?php
namespace App\Handler\Admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Laminas\Diactoros\Response\JsonResponse;

class ResetHandler implements RequestHandlerInterface
{
  protected $debug = false;
  protected $services = [];
  
  public function __construct($debug, $services) {
    $this->debug = $debug;
    $this->services = $services;
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    if ($this->debug != true) {
      return new JsonResponse(['error' => 'not in debug mode'], 404);
    }

    $servicesResult = $this->resetServices();

    $result = array_reduce($servicesResult, function($carry, $item) {
      return (is_null($carry) ? true : false) && $item['result'];
    });

    return new JsonResponse(
      [
        'debug' => $this->debug,
        'services' => $servicesResult
      ],$result ? 200 : 404);
  }

  protected function resetServices() {
    $result = [];

    foreach ($this->services as $key => $service) {
      $result[$key] = method_exists($service, 'resetService') ? $service->resetService() : false;
    }

    return $result;
  }
}
