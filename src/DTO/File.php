<?php

namespace Flowgistics\PhpNotionClient\DTO;

class File
{
    public function __construct(
        public string $url,
        public string $expiryTime,
    ) {}

    /**
     * @param array{
     *     url: string,
     *     expiry_time: string
     * } $data
     *
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            url: $data['url'],
            expiryTime: $data['expiry_time'],
        );
    }
}
