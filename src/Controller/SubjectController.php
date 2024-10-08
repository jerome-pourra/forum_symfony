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
        private SubjectService $subjectService,
        private MessageService $messageService
    ) {
    }

    #[Route('', name: 'app_subject_list', methods: ['GET'])]
    public function list(Request $request): Response
    {

        $form = $this->createForm(SubjectFiltersType::class);
        $form->handleRequest($request);

        $result = $this->subjectService->getList($request);

        $subjects = [];
        foreach ($result['items'] as $subject) {
            $subjects[] = [
                'entity' => $subject,
                'messagesCount' => $this->messageService->getCountBySubject($subject)
            ];
        }

        return $this->render('subjects/list.html.twig', [
            'subjects' => $subjects,
            'count' => $result['count'],
            'context' => $result['context'],
            'formFilters' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_subject_item', methods: ['GET'])]
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
