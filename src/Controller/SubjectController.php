<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\MessageFiltersType;
use App\Form\SubjectFiltersType;
use App\Service\BreadcrumbService;
use App\Service\MessageService;
use App\Service\SubjectService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/subject')]
class SubjectController extends AbstractCustomController
{

    public function __construct(
        BreadcrumbService $breadcrumbService,
        private SubjectService $subjectService,
        private MessageService $messageService
    ) {
        parent::__construct($breadcrumbService);
    }

    #[Route('', name: 'app_subject_list')]
    public function list(Request $request): Response
    {

        $form = $this->createForm(SubjectFiltersType::class);
        $form->handleRequest($request);

        $result = $this->subjectService->getList($request);
        return $this->render('subjects/list.html.twig', [
            'items' => $result['items'],
            'count' => $result['count'],
            'context' => $result['context'],
            'formFilters' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_subject_item')]
    public function item(?Subject $subject, Request $request): Response
    {

        if ($subject === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(MessageFiltersType::class);
        $form->handleRequest($request);

        $result = $this->messageService->getListByKey($request, 'subject', $subject);
        return $this->render('subjects/item.html.twig', [
            'subject' => $subject,
            'messages' => $result['items'],
            'count' => $result['count'],
            'context' => $result['context'],
            'formFilters' => $form->createView(),
        ]);

    }
}
