<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use App\Service\SleekDBService;

class TeamHandler implements RequestHandlerInterface
{
    /** @var string */
    private $store;

    public function __construct(SleekDBService $sleekDB) {
      $this->store = $sleekDB->getStore('teams');
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
      $method = $request->getMethod();

      if(method_exists($this, $method)) {
        return $this->$method($request);
      }
      else {
        return new JsonResponse([]);
      }
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
      $id = $request->getAttribute('id');

      if(is_numeric($id)) {
        $store = $this->store->where('_id', '=', $id);
      } else {
        $store = $this->store;
      }

      $items = $store->fetch();

      return new JsonResponse(['teams' => $items]);
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
      $body = $request->getParsedBody();
      $items = $this->store->insert($body);

        return new JsonResponse(['teams' => $items]);
    }

    public function put(ServerRequestInterface $request): ResponseInterface
    {
      $id = $request->getAttribute('id');

      if(is_numeric($id)) {
        $body = $request->getParsedBody();
        $items = $this->store->where('_id', '=', $id)->update($body);

        return new JsonResponse(['teams' => $item]);
      } else {
        return new JsonResponse([false]);
      }
    }

    public function delete(ServerRequestInterface $request): ResponseInterface
    {
      $id = $request->getAttribute('id');

      if(is_numeric($id)) {
        $item = $this->store->where('_id', '=', $id)->delete();

        return new JsonResponse($item);
      } else {
        return new JsonResponse([false]);
      } 
    }
}
