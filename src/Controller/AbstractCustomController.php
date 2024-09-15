<?php

namespace App\Controller;
use App\Service\BreadcrumbService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractCustomController extends AbstractController
{

    protected BreadcrumbService $breadcrumbService;
    protected SessionInterface $session;

    #[Required]
    public function autowire(BreadcrumbService $breadcrumbService, RequestStack $requestStack): void
    {
        $this->breadcrumbService = $breadcrumbService;
        $this->session = $requestStack->getSession();
    }

    protected function render(string $view, array $parameters = [], Response|null $response = null): Response
    {
        $parameters['theme'] = $this->session->get('theme', ThemeController::DEFAULT_THEME);
        $parameters['breadcrumbs'] = $this->breadcrumbService->generateBreadcrumb();
        return parent::render($view, $parameters, $response);
    }

}