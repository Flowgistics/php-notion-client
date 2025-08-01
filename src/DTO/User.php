<?php

namespace Flowgistics\PhpNotionClient\DTO;

class User
{
    public function __construct(
        public string $id,
        public string $object,
    ) {}

    /**
     * @param array{
     *     id: string,
     *     object: string
     * } $data
     *
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'],
        );
    }
}
