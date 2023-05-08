<?php

namespace App\Domain\Tache\Service;

use App\Domain\Tache\Repository\TachesRepository;

final class TacheUpdate
{
    private $repository;

    public function __construct(TachesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function modifierTache(int $tacheId, array $data): void
    {
        $this->repository->updateTache($tacheId, $data);
    }
}
