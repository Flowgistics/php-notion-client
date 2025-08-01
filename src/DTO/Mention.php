<?php

namespace Flowgistics\PhpNotionClient\DTO;

use Flowgistics\PhpNotionClient\DTO\Properties\Date;

class Mention
{
    public function __construct(
        public string $type,
        public ?Date  $date,
        public ?User $user,
    ) {}

    public static function fromArray(array $data): Mention
    {
        return new self(
            type: $data['type'],
            date: Date::fromArray($data['date']),
            user: User::fromArray($data['user']),
        );
    }
}
