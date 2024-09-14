<?php

namespace App\Twig\Components\Utils;
use App\Utils\RequestContext;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Pagination
{
    public int $totalcount;
    public RequestContext $context;

    public function getCurrentPage(): int
    {
        $offset = $this->context->getOffset();
        $limit = $this->context->getLimit();
        return floor($offset / $limit + 1);
    }

    public function getPages(): array
    {
        $firstPage = $this->getFirstPage();
        $lastPage = $this->getLastPage();
        $currentPage = $this->getCurrentPage();

        $pages = [];
        for ($i = $firstPage; $i <= $lastPage; $i++) {
            $pages[] = [
                'num' => $i,
                'active' => $i === $currentPage,
                'offset' => $this->getPageOffset($i),
            ];
        }
        return $pages;
    }

    private function getFirstPage(): int
    {
        return 1;
    }

    private function getLastPage(): int
    {
        return ceil($this->totalcount / $this->context->getLimit());
    }

    private function getPageOffset(int $page): int
    {
        return ($page - 1) * $this->context->getLimit();
    }
}