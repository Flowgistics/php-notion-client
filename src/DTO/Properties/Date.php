<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class Date implements Arrayable
{
    public const string TYPE = 'date';

    public function __construct(
        public string $start,
        public ?string $end,
        public ?string $timeZone = null,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            start: is_string($array['start'] ?? null) ? $array['start'] : '',
            end: is_string($array['end'] ?? null) ? $array['end'] : null,
            timeZone: is_string($array['time_zone'] ?? null) ? $array['time_zone'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type'      => self::TYPE,
            'start'     => $this->start,
            'end'       => $this->end,
            'time_zone' => $this->timeZone,
        ];
    }
}
