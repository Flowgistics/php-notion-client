<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

class Email
{
    public const string TYPE = 'email';

    public function __construct(
        public string $email,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            email: $array['email'],
        );
    }
}
