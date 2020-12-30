<?php

declare(strict_types=1);

namespace App\Handler\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\EmptyResponse;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use App\Service\LeagueService;

class LeagueHandler implements RequestHandlerInterface
{
    private $leagueService;

    public function __construct(LeagueService $leagueService) {
      $this->leagueService = $leagueService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
      $method = $request->getMethod();

      if(method_exists($this, $method)) {
        return $this->$method($request);
      }
      else {
        return new JsonResponse(null);
      }
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
      $id = $request->getAttribute('id');

      if (is_null($id)) {
        $result = $this->leagueService->findAll();
      }
      else {
        $result = $this->leagueService->findOne($id);
      }

      return $result ? new JsonResponse($result) : new EmptyResponse(404);
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
      $league = $request->getParsedBody();
      $result = $this->leagueService->create($league);

      return $result ? new JsonResponse($result) : new EmptyResponse(404);
    }

    public function put(ServerRequestInterface $request): ResponseInterface
    {
      $id = $request->getAttribute('id');
      $league = $request->getParsedBody();
      $result = $this->leagueService->update($id, $league);

      return $result ? new JsonResponse($result) : new EmptyResponse(404);
    }

    public function delete(ServerRequestInterface $request): ResponseInterface
    {
      $id = $request->getAttribute('id');
      $result = $this->leagueService->delete($id);

      return $result ? new EmptyResponse(200) : new EmptyResponse(404);
    }
}
