<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class Text implements Arrayable
{
    public function __construct(
        public string $content,
        public ?string $link = null,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        $link = $array['link'] ?? null;

        return new self(
            content: is_string($array['content'] ?? null) ? $array['content'] : '',
            link: is_array($link) && is_string($link['url'] ?? null) ? $link['url'] : (is_string($link) ? $link : null),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'link'    => $this->link ? ["url" => $this->link] : null,
        ];
    }
}
