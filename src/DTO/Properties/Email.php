<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

class Email implements Arrayable
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

    public function toArray(): array
    {
        return [
            'type'  => self::TYPE,
            'email' => $this->email,
        ];
    }
}
