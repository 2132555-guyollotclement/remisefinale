<?php

namespace App\Domain\Tache\Service;

use App\Domain\Tache\Repository\TachesRepository;

final class TacheCreate
{
    private $repository;

    public function __construct(TachesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function creerTache(array $data): int
    {
        $tacheId = $this->repository->insereTache($data);

        return $tacheId;
    }
}
