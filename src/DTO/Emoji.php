<?php

namespace Flowgistics\PhpNotionClient\DTO;

class Emoji
{
    public function __construct(
        public string $emoji,
    ) {}

    /**
     * @param array{
     *     emoji: string
     * } $data
     *
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['emoji'],
        );
    }
}
