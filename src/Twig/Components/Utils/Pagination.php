<?php

namespace App\Twig\Components\Utils;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Pagination {
    public int $totalPages;
    public int $currentPage;
}