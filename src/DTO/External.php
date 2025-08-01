<?php

namespace Flowgistics\PhpNotionClient\DTO;

class External
{
    public function __construct(
        public string $url,
    ) {}

    /**
     * @param array{
     *     url: string
     * } $data
     *
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['url'],
        );
    }
}
