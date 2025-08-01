<?php

namespace Flowgistics\PhpNotionClient\Requests\Pages;

use Flowgistics\PhpNotionClient\DTO\Page;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Saloon\Traits\Body\HasJsonBody;

class PostPagesRequest extends Request implements Paginatable, HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected string $databaseId) {}

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return "/databases/$this->databaseId/query";
    }

    /**
     * @param Response $response
     *
     * @return array<int, Page>
     * @throws \JsonException
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(function (array $page) {
            return Page::fromArray($page);
        }, $response->json('results'));
    }
}
