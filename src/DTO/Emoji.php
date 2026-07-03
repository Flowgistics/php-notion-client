<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO;

class Emoji
{
    public function __construct(
        public string $emoji,
    ) {}

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            is_string($data['emoji'] ?? null) ? $data['emoji'] : '',
        );
    }
}
