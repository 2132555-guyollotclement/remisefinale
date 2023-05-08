<?php

namespace App\Domain\Tache\Service;

use App\Domain\Tache\Repository\TachesRepository;

final class TacheView
{
    private $repository;

    public function __construct(TachesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function afficheTaches(): array
    {
        $taches = $this->repository->selectTaches();

        return $taches;
    }
}
