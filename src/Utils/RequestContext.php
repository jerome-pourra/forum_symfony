<?php

namespace App\Utils;
use App\Form\Choices\LimitChoiceEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RequestContext
{

    private const MIN_LIMIT = LimitChoiceEnum::LIMIT_10->value;
    private const MAX_LIMIT = LimitChoiceEnum::LIMIT_100->value;

    private const MIN_OFFSET = 0;
    private const DEFAULT_OFFSET = 0;

    private array $filters = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private ?array $orderBy = null;

    public function __construct(
        private Request $request,
        private UrlGeneratorInterface $router
    ) {

        $this->request = $request;

        $limit = $request->query->getInt('limit', self::MIN_LIMIT);
        $this->limit = min(max($limit, self::MIN_LIMIT), self::MAX_LIMIT);

        $offset = $request->query->getInt('offset', self::DEFAULT_OFFSET);
        $this->offset = max($offset, self::MIN_OFFSET);

        $orderBy = $request->query->get('orderBy', null);
        $orderOperator = $request->query->get('orderOperator', null);

        if ($orderBy && $orderOperator) {
            $this->orderBy = [$orderBy => $orderOperator];
        }
        
    }

    public function getQueryParams(): array
    {
        return $this->request->query->all();
    }

    public function mergeQueryParams(array $params): array
    {
        return array_merge($this->request->query->all(), $params);
    }

    public function getRoute(): ?string
    {
        return $this->request->attributes->get('_route', null);
    }

    public function getRouteAttributes(): array
    {
        return $this->request->attributes->get('_route_params', []);
    }

    public function generateUrl(array $params): string
    {

        $url = $this->router->generate($this->getRoute(), $this->getRouteAttributes());
        $queryParams = $this->mergeQueryParams($params);

        // Symfony gère les attributs de la route et les parametres de query string automatiquement
        // Le problème étant que si ma route est /subject/{id} et que je passe ['id' => 2] en parametre
        // Symfony ne semble pas générer la route correment étant donné que le parametre id est déjà présent dans la route
        // Et que les parametres de query string sont mergé avec les attributs de la route
        // On passe par http_build_query pour plus de clarté et séparer les parametres de la route et les parametres de query string

        if (!empty($queryParams)) {
            $url = $url . '?' . http_build_query($queryParams);
        }

        return $url;

    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getOrderBy(): ?array
    {
        return $this->orderBy;
    }
}