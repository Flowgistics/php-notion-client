<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO\Properties;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class Formula implements Arrayable
{
    public const string TYPE = 'formula';

    public function __construct(
        public string $type,
        public int|float|null $number = null,
        public ?string $string = null,
        /** @var array<mixed, mixed>|null */
        public ?array $date = null,
        public ?bool $boolean = null,
    ) {}

    /**
     * @param array<mixed, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        $number = $array['number'] ?? null;

        return new self(
            type: is_string($array['type'] ?? null) ? $array['type'] : '',
            number: is_int($number) || is_float($number) ? $number : null,
            string: is_string($array['string'] ?? null) ? $array['string'] : null,
            date: is_array($array['date'] ?? null) ? $array['date'] : null,
            boolean: is_bool($array['boolean'] ?? null) ? $array['boolean'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'type'    => $this->type,
            'number'  => $this->number,
            'string'  => $this->string,
            'date'    => $this->date,
            'boolean' => $this->boolean,
        ];
    }
}
