<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectFiltersType;
use App\Service\BreadcrumbService;
use App\Service\MessageService;
use App\Service\SubjectService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class HomeController extends AbstractCustomController
{
    public function __construct(
        BreadcrumbService $breadcrumbService,
    ) {
        parent::__construct($breadcrumbService);
    }

    #[Route('', name: 'app_home_index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'links' => [
                ['label' => 'Subjects', 'url' => $this->generateUrl('app_subject_list'), 'style' => 'primary'],
                ['label' => 'Github', 'url' => 'https://github.com/jerome-pourra/forum_symfony', 'target' => '_blank', 'style' => 'light'],
                ['label' => 'Readme', 'url' => 'https://shattereddisk.github.io/rickroll/rickroll.mp4', 'target' => '_blank', 'style' => 'danger']
            ],
        ]);
    }
}
