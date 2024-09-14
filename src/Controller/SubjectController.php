<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Service\SubjectService;
use App\Service\Ui\SubjectUiService;
use App\Utils\RequestContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/subjects')]
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
        $result = $this->service->getList($request);
        return $this->render('subjects/list.html.twig', [
            'items' => $result['items'],
            'count' => $result['count'],
            'context' => $result['context'],
        ]);
    }
}
