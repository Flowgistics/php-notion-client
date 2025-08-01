<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

class CheckBox
{
    public const string TYPE = 'check_box';

    public function __construct(
        public bool $checked,
    ) {}

    public static function fromArray(array $array): self
    {
        return new self(
            checked: $array['checked'],
        );
    }
}
