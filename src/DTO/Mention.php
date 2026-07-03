<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO;

use Flowgistics\PhpNotionClient\DTO\Properties\Date;

class Mention
{
    /**
     * @param array<mixed, mixed>|null $data
     */
    public function __construct(
        public string $type,
        public ?Date $date = null,
        public ?User $user = null,
        public ?array $data = null,
    ) {}

    /**
     * @param array<mixed, mixed> $data
     */
    public static function fromArray(array $data): Mention
    {
        $type = is_string($data['type'] ?? null) ? $data['type'] : '';

        return new self(
            type: $type,
            date: is_array($data['date'] ?? null) ? Date::fromArray($data['date']) : null,
            user: is_array($data['user'] ?? null) ? User::fromArray($data['user']) : null,
            data: is_array($data[$type] ?? null) ? $data[$type] : null,
        );
    }
}
