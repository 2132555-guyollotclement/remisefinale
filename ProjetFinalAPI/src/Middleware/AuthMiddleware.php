<?php

namespace App\Middleware;

use App\Domain\ApiKey\Repository\ApiKeyRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    private $apiKeyRepository;

    public function __construct(ApiKeyRepository $apiKeyRepository)
    {
        $this->apiKeyRepository = $apiKeyRepository;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Récupérer la clé API du header "Authorization"
        $authorizationHeader = $request->getHeaderLine('Authorization');
        $apiKey = str_replace('Bearer ', '', $authorizationHeader);

        // Vérifier si la clé API est valide en utilisant getUserByApiKey()
        $user = $this->apiKeyRepository->getUserByApiKey($apiKey);

        if ($user === null) {
            // La clé API n'est pas valide
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode(['error' => 'L\'API key n\'est pas valide']));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }

        // Ajouter l'objet utilisateur à la requête pour une utilisation ultérieure
        $request = $request->withAttribute('user', $user);

        // Si la clé API est valide, passer la requête au prochain middleware ou à l'action
        $response = $handler->handle($request);

        return $response;
    }
}
