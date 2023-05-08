<?php

namespace App\Action\Tache;

use App\Domain\Tache\Service\TacheCreate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TacheCreateAction
{
    private $tacheCreate;

    public function __construct(TacheCreate $tacheCreate)
    {
        $this->tacheCreate = $tacheCreate;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $data = (array)$request->getParsedBody();

        $tacheId = $this->tacheCreate->creerTache($data);

        $result = [
            'tache_id' => $tacheId
        ];

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
