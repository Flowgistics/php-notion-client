<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

class PhoneNumber
{
    public const string TYPE = 'phone_number';

    public function __construct(
        public string $phoneNumber,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            phoneNumber: $array['phoneNumber'],
        );
    }
}
