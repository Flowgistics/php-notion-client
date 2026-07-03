<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\Resources;

use Flowgistics\PhpNotionClient\DTO\Page;
use Flowgistics\PhpNotionClient\NotionClient;
use Flowgistics\PhpNotionClient\Requests\Pages\CreatePageRequest;
use Flowgistics\PhpNotionClient\Requests\Pages\GetPageRequest;
use Flowgistics\PhpNotionClient\Requests\Pages\PatchPageRequest;
use Flowgistics\PhpNotionClient\Requests\Pages\PostPagesRequest;
use Iterator;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\CursorPaginator;

class PagesResource extends BaseResource
{
    public function all(string $databaseId): Response
    {
        return $this->connector->send(new PostPagesRequest($databaseId));
    }

    /**
     * @param array<mixed, mixed> $payload
     */
    public function updatePage(string $pageId, array $payload): Response
    {
        return $this->connector->send(new PatchPageRequest($pageId, $payload));
    }

    public function get(string $pageId): Page
    {
        $page = $this->connector->send(new GetPageRequest($pageId))->dto();

        return $page instanceof Page ? $page : Page::fromArray([]);
    }

    /**
     * @param array<mixed, mixed> $payload
     */
    public function create(array $payload): Response
    {
        return $this->connector->send(new CreatePageRequest($payload));
    }

    /**
     * @param string $databaseId
     *
     * @return Iterator<int, Page>
     */
    public function paginate(string $databaseId): Iterator
    {
        if (!$this->connector instanceof NotionClient) {
            throw new \RuntimeException('Pages pagination requires a NotionClient connector.');
        }

        /** @var CursorPaginator $paginator */
        $paginator = $this->connector->paginate(new PostPagesRequest($databaseId));

        /** @var Iterator<int, Page> */
        return $paginator->items();
    }
}
