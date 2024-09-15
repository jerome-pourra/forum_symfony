<?php
namespace App\Controller;

use App\Twig\Extensions\IconExtension;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/theme')]
class ThemeController extends AbstractCustomController
{
    public const DEFAULT_THEME = 'dark';

    #[Route('', name: 'api_theme_toogle', methods: ['POST'])]
    public function toogleTheme(): JsonResponse
    {
        $old = $this->session->get('theme', self::DEFAULT_THEME);
        $new = $old === 'light' ? 'dark' : 'light';
        $this->session->set('theme', $new);
        // TODO: refacto cette grosse daube !
        $icon = IconExtension::themeIcon($new);
        return new JsonResponse([
            'theme' => $new,
            'icon' => $icon,
        ]);
    }
}