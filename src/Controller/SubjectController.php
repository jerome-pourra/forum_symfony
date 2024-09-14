<?php

namespace App\Controller;

use App\Form\SubjectFiltersType;
use App\Service\SubjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('')]
class SubjectController extends AbstractController
{

    private SubjectService $service;

    public function __construct(SubjectService $service)
    {
        $this->service = $service;
    }

    #[Route('', name: 'app_subject_list')]
    public function list(Request $request): Response
    {

        $form = $this->createForm(SubjectFiltersType::class);
        $form->handleRequest($request);

        $result = $this->service->getList($request);
        return $this->render('subjects/list.html.twig', [
            'items' => $result['items'],
            'count' => $result['count'],
            'context' => $result['context'],
            'formFilters' => $form->createView(),
        ]);
    }
}
