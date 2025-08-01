<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

class Files
{
    public const string TYPE = 'files';

    public function __construct(
        public array $files,
    ) {}
}
//@TODO
