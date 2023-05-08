<?php

namespace App\Domain\Tache\Service;

use App\Domain\Tache\Repository\TachesRepository;

final class TacheDelete
{
    private $repository;

    public function __construct(TachesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function supprimerTache(int $tacheId): void
    {
        $this->repository->deleteTache($tacheId);
    }
}
