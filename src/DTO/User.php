<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO;

class User
{
    public function __construct(
        public string $id,
        public string $object,
    ) {}

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: is_string($data['id'] ?? null) ? $data['id'] : '',
            object: is_string($data['object'] ?? null) ? $data['object'] : 'user',
        );
    }
}
