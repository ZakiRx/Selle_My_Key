<?php

declare(strict_types=1);
namespace App\Service;


use App\Repository\GenreRepository;

class GenreService
{

    /**
     * @var GenreRepository
     */
    private $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

}