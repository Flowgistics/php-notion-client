<?php

namespace Flowgistics\PhpNotionClient\Resources;

use Flowgistics\PhpNotionClient\DTO\Page;
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

    public function updatePage(string $pageId, array $payload)
    {
        return $this->connector->send(new PatchPageRequest($pageId, $payload));
    }

    public function get(string $pageId): Page
    {
        return $this->connector->send(new GetPageRequest($pageId))->dto();
    }

    /**
     * @param string $databaseId
     *
     * @return Iterator<int, Page>
     */
    public function paginate(string $databaseId): Iterator
    {
        /** @var CursorPaginator $paginator */
        $paginator = $this->connector->paginate(new PostPagesRequest($databaseId));

        /** @var Iterator<int, Page> */
        return $paginator->items();
    }
}
