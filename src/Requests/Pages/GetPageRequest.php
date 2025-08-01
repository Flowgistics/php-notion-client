<?php

namespace Flowgistics\PhpNotionClient\Requests\Pages;

use Flowgistics\PhpNotionClient\DTO\Page;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class GetPageRequest extends Request {

    protected Method $method = Method::GET;

    /**
     * @param string $pageId
     */
    public function __construct(
        protected string $pageId,
    ) {}

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return "/pages/$this->pageId";
    }

    /**
     * @param Response $response
     *
     * @return array<int, Page>
     * @throws \JsonException
     */
    public function createDtoFromResponse(Response $response): Page
    {
        return Page::fromArray($response->json());
    }
}
