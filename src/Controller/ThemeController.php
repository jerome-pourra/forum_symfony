<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/theme')]
class ThemeController extends AbstractCustomController
{
    public const DEFAULT_THEME = 'dark';

    #[Route('', name: 'api_theme_toogle', methods: ['GET'])]
    public function toogleTheme(): JsonResponse
    {
        $old = $this->session->get('theme', self::DEFAULT_THEME);
        $new = $old === 'light' ? 'dark' : 'light';
        $this->session->set('theme', $new);
        return new JsonResponse(['theme' => $new]);
    }
}