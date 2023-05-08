<?php

namespace App\Domain\Tache\Service;

use App\Domain\Tache\Repository\TachesRepository;

use App\Factory\LoggerFactory;

final class AuthService
{
    private TachesRepository $userRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(TachesRepository $userRepository, LoggerFactory $loggerFactory)
    {
        $this->userRepository = $userRepository;
        $this->logger = $loggerFactory
            ->addFileHandler('login_view.log')
            ->createLogger('Message de debug');
    }

    public function authentification(string $username, string $password): ?array
    {
        // Trouver l'utilisateur par nom d'utilisateur
        $user = $this->userRepository->chercherUtilisateur($username);

        // Vérifier si l'utilisateur existe et si le mot de passe correspond
        if (!password_verify($password, $user['password'])) {
            return null;
        }

        return $user;
    }
}
