<?php

namespace App\Action\Tache;

use App\Domain\Tache\Service\TacheDelete;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TacheDeleteAction
{
    private $tacheDelete;

    public function __construct(TacheDelete $tacheDelete)
    {
        $this->tacheDelete = $tacheDelete;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
        ): ResponseInterface {
            $tacheId = (int)$request->getAttribute('id');

            $this->tacheDelete->supprimerTache($tacheId);
        
            return $response
                ->withStatus(204);
        }
    }        