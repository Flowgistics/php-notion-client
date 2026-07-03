<?php

declare(strict_types=1);

namespace Flowgistics\PhpNotionClient\DTO\Properties;

//@TODO
class Files
{
    public const string TYPE = 'files';

    /**
     * @param array<mixed, mixed> $files
     */
    public function __construct(
        public array $files,
    ) {}
}
