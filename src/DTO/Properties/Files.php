<?php

namespace Flowgistics\PhpNotionClient\DTO\Properties;

//@TODO
class Files
{
    public const string TYPE = 'files';

    public function __construct(
        public array $files,
    ) {}
}

