<?php

namespace Flowgistics\PhpNotionClient;

use Flowgistics\PhpNotionClient\Resources\PagesResource;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\CursorPaginator;

class NotionClient extends Connector implements HasPagination
{
    public function __construct(protected readonly string $apikey) {}

    /**
     * {@inheritDoc}
     */
    public function resolveBaseUrl(): string
    {
        return 'https://api.notion.com/v1';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept'         => 'application/json',
            'Content-Type'   => 'application/json',
            'Notion-Version' => '2025-09-03',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->apikey);
    }

    public function pages(): PagesResource
    {
        return new PagesResource($this);
    }

    public function paginate(Request $request): CursorPaginator
    {
        return new class (connector: $this, request: $request) extends CursorPaginator {
            protected ?int $perPageLimit = 5;

            protected function isLastPage(Response $response): bool
            {
                return is_null($response->json('next_cursor'));
            }

            protected function getPageItems(Response $response, Request $request): array
            {
                return $response->dto();
            }

            protected function getNextCursor(Response $response): int|string
            {
                return $response->json('next_cursor');
            }

            protected function applyPagination(Request $request): Request
            {
                if ($this->currentResponse instanceof Response) {
                    if ($request instanceof HasBody && $request->getMethod() === Method::POST) {
                        $request->body()->add('start_cursor', $this->getNextCursor($this->currentResponse));
                    } elseif ($request->getMethod() === Method::GET) {
                        $request->query()->add('start_cursor', $this->getNextCursor($this->currentResponse));
                    }
                }

                if (isset($this->perPageLimit)) {
                    if ($request instanceof HasBody && $request->getMethod() === Method::POST) {
                        $request->body()->add('page_size', $this->perPageLimit);
                    } elseif ($request->getMethod() === Method::GET) {
                        $request->query()->add('page_size', $this->perPageLimit);
                    }
                }

                return $request;
            }
        };
    }

}
