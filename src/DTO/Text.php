<?php

namespace Flowgistics\PhpNotionClient\DTO;

use JsonSerializable;

class Text implements JsonSerializable
{
    public function __construct(
        public string $content,
        public ?array $link = null,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            content: $array['content'],
            link: $array['link'], //@todo
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'content' => $this->content,
            //            'link' => $this->link,
        ];
    }
}
