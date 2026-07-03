<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO;

class File
{
    public function __construct(
        public string $url,
        public string $expiryTime,
    ) {}

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            url: is_string($data['url'] ?? null) ? $data['url'] : '',
            expiryTime: is_string($data['expiry_time'] ?? null) ? $data['expiry_time'] : '',
        );
    }
}
