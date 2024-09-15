<?php

namespace App\Controller;
use App\Service\BreadcrumbService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractCustomController extends AbstractController
{
    public function __construct(
        protected BreadcrumbService $breadcrumbService
    ) {
    }

    protected function render(string $view, array $parameters = [], Response|null $response = null): Response
    {
        $parameters['breadcrumbs'] = $this->breadcrumbService->generateBreadcrumb();
        return parent::render($view, $parameters, $response);
    }

}