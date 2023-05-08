<?php

namespace App\Action\Tache;

use App\Domain\Tache\Service\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Factory\LoggerFactory;

final class LoginViewAction
{
    private AuthService $authService;

    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(AuthService $authService, LoggerFactory $loggerFactory)
    {
        $this->authService = $authService;

        $this->logger = $loggerFactory
            ->addFileHandler('login_view.log')
            ->createLogger('Message de debug');
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data = (array)$request->getParsedBody();

        $username = $data['username'];
        $password = $data['password'];

        $this->logger->info($data['username']);
        $this->logger->info($data['password']);
        $this->logger->info($data['api_key']);

        $user = $this->authService->authentification($username, $password);

        if ($user) {
            // Utilisateur authentifié avec succès, retourner l'API key
            $result = [
                'api_key' => $user['api_key']
            ];

            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            // Échec de l'authentification
            $response->getBody()->write(json_encode(['api_key' => null]));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
}
