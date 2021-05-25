<?php

declare(strict_types=1);

namespace App\Service;


use App\Repository\FavoriteRepository;

class FavoriteService
{
    /**
     * @var FavoriteRepository
     */
    private $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }
}