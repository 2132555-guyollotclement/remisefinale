<?php

namespace App\Domain\Tache\Service;

use App\Domain\ApiKey\Repository\ApiKeyRepository;

final class ApiKeyGenerate
{
    private $repository;

    public function __construct(ApiKeyRepository $repository)
    {
        $this->repository = $repository;
    }

public function genererApiKey(array $data): ?array
{
    $user = $this->repository->verifierIdentifiantsUsager($data['username'], $data['password']);

    if ($user) {
        if (empty($user['api_key'])) {
            $user['api_key'] = $this->repository->creerApiKey($user);
        }
        unset($user['password']);
        return $user;
    }

    return null;
}



}
