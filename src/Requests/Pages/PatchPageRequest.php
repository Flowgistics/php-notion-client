<?php

namespace Flowgistics\PhpNotionClient\Requests\Pages;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PatchPageRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /**
     * @param string $pageId
     * @param array  $payload
     */
    public function __construct(
        protected string $pageId,
        protected array $payload,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function resolveEndpoint(): string
    {
        return "/pages/$this->pageId";
    }

    public function defaultBody(): array
    {
        return [
            "properties" => $this->payload,
        ];
    }
}
