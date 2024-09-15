<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class HomeController extends AbstractCustomController
{
    #[Route('', name: 'app_home_index', methods: ['GET'])]
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
