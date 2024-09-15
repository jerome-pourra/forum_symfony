<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class BreadcrumbService
{
    public function __construct(
        private RequestStack $requestStack,
        private RouterInterface $router,
        private SubjectService $subjectService
    ) {
    }

    public function generateBreadcrumb(): array
    {
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->attributes->get('_route');
        $routeParams = $request->attributes->get('_route_params', []);

        $breadcrumbs = [];

        switch ($route) {
            case 'app_subject_list':
                $breadcrumbs[] = ['label' => 'Home', 'html' => '<span class="material-symbols-outlined">home</span>', 'url' => $this->router->generate('app_home_index')];
                $breadcrumbs[] = ['label' => 'Subjects', 'url' => $this->router->generate('app_subject_list')];
                break;
            case 'app_subject_item':
                $subject = $this->subjectService->getOne($routeParams['id']);
                $breadcrumbs[] = ['label' => 'Home', 'html' => '<span class="material-symbols-outlined">home</span>', 'url' => $this->router->generate('app_home_index')];
                $breadcrumbs[] = ['label' => 'Subjects', 'url' => $this->router->generate('app_subject_list')];
                $breadcrumbs[] = ['label' => $subject->getTitle(), 'url' => $this->router->generate('app_subject_item', $routeParams)];
                break;
        }

        return $breadcrumbs;
    }
}