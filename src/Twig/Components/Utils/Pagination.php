<?php

namespace App\Twig\Components\Utils;
use App\Utils\RequestContext;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class Pagination
{
    
    private const ADJACENT_COUNT = 5; 
    private const PAGE_TYPE_LINK = 'link';
    private const PAGE_TYPE_SEPARATOR = 'separator';

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

        if ($firstPage < $currentPage - self::ADJACENT_COUNT) {
            $pages[] = $this->createPage($firstPage, $currentPage);
            if ($firstPage + 1 < $currentPage - self::ADJACENT_COUNT) {
                $pages[] = $this->createSeparator();
            }
        }

        for ($i = max($firstPage, $currentPage - self::ADJACENT_COUNT); $i < $currentPage; $i++) {
            $pages[] = $this->createPage($i, $currentPage);
        }

        $pages[] = $this->createPage($currentPage, $currentPage);

        for ($i = $currentPage + 1; $i <= min($lastPage, $currentPage + self::ADJACENT_COUNT); $i++) {
            $pages[] = $this->createPage($i, $currentPage);
        }

        if ($lastPage > $currentPage + self::ADJACENT_COUNT) {
            if ($lastPage - 1 > $currentPage + self::ADJACENT_COUNT) {
                $pages[] = $this->createSeparator();
            }
            $pages[] = $this->createPage($lastPage, $currentPage);
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

    private function createPage(int $page, int $current): array
    {
        return [
            'label' => $page,
            'type' => self::PAGE_TYPE_LINK,
            'url' => $this->context->generateUrl(['offset' => $this->getPageOffset($page)]),
            'active' => $page === $current,
            'offset' => $this->getPageOffset($page),
        ];
    }

    private function createSeparator(): array
    {
        return [
            'label' => '...',
            'type' => self::PAGE_TYPE_SEPARATOR,
        ];
    }
}