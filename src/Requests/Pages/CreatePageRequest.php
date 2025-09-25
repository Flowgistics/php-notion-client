<?php

namespace Flowgistics\PhpNotionClient\Requests\Pages;

use Flowgistics\PhpNotionClient\DTO\Page;
use Illuminate\Contracts\Support\Arrayable;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreatePageRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param array $payload
     */
    public function __construct(
        protected array $payload = [],
    ) {}

    /**
     * @inheritDoc
     */
    public function resolveEndpoint(): string
    {
        return "/pages";
    }

    public function defaultBody(): array
    {
        if(isset($this->payload['properties'])) {
            $this->payload['properties'] = array_map(function (mixed $property) {
                if($property instanceof Arrayable) {
                    return $property->toArray();
                }
                return $property;
            }, $this->payload['properties']);
        }

        if(isset($this->payload['children'])) {
            $this->payload['children'] = array_map(function (array $properties) {
                return array_map(function (mixed $property) {
                    if($property instanceof Arrayable) {
                        return $property->toArray();
                    }
                    return $property;
                }, $properties);
            }, $this->payload['children']);
        }

        return $this->payload;
    }

    /**
     * @param Response $response
     *
     * @return Page
     * @throws \JsonException
     */
    public function createDtoFromResponse(Response $response): Page
    {
        return Page::fromArray($response->json());
    }
}
