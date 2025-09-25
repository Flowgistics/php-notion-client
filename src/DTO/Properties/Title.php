<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

/**
 * Title is the same as a RichText but instead of the property `rich_text` it uses `title`
 */
class Title extends RichText
{
    public const string TYPE = 'title';

    public function toArray(): array
    {
        return [
            'type'  => self::TYPE,
            'title' => $this->mapData(),
        ];
    }
}
