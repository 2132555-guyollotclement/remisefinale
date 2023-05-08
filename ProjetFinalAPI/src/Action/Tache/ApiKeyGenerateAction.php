<?php

namespace App\Action\Tache;

use App\Domain\ApiKey\Repository\ApiKeyRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiKeyGenerateAction
{
    private $repository;

    public function __construct(ApiKeyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = (array)$request->getParsedBody();

        $username = $data['username'];

        $user = $this->repository->verifierIdentifiantsUsager($username);

        if ($user) {
            // Générer et mettre à jour la clé API pour cet utilisateur
            $apiKey = $this->repository->creerApiKey($user);

            // Mettre à jour la réponse avec la clé API générée
            $response->getBody()->write(json_encode(['api_key' => $apiKey]));
            return $response->withHeader('Content-Type', 'application/json')
                            ->withStatus(201);
        }

        // Si l'utilisateur n'est pas trouvé, renvoyer une erreur 401 non autorisée
        return $response->withStatus(401);
    }
}
