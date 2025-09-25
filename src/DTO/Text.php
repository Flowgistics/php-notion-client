<?php

namespace Flowgistics\PhpNotionClient\DTO;

use Illuminate\Contracts\Support\Arrayable;

class Text implements Arrayable
{
    public function __construct(
        public string $content,
        public ?string $link = null,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            content: $array['content'],
            link: $array['link'],
        );
    }

    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'link' => $this->link ? ["url" => $this->link] : null,
        ];
    }
}
