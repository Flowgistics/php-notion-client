<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\Enums;

enum RichTextType: string
{
    case Text = 'text';
    case Mention = 'mention';
    case Equation = 'equation';

}
