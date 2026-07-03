<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO;

class External
{
    public function __construct(
        public string $url,
    ) {}

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            is_string($data['url'] ?? null) ? $data['url'] : '',
        );
    }
}
