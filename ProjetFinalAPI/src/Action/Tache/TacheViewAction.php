<?php

namespace App\Action\Tache;

use App\Domain\Tache\Service\TacheView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TacheViewAction
{
    private $tacheView;

    public function __construct(TacheView $tacheView)
    {
        $this->tacheView = $tacheView;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $taches = $this->tacheView->afficheTaches();

        $response->getBody()->write(json_encode($taches));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
