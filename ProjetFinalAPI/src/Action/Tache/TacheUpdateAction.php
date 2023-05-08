<?php

namespace App\Action\Tache;

use App\Domain\Tache\Service\TacheUpdate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TacheUpdateAction
{
    private $tacheUpdate;

    public function __construct(TacheUpdate $tacheUpdate)
    {
        $this->tacheUpdate = $tacheUpdate;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        $tacheId = (int)$request->getAttribute('id');
        $data = (array)$request->getParsedBody();

        $this->tacheUpdate->modifierTache($tacheId, $data);

        return $response
            ->withStatus(204);
    }
}
