<?php

namespace AppBundle\Service;

/**
 * Interface AbstractParser
 * @package AppBundle\Service
 */
interface AbstractParser
{
    public function __construct(string $path);
    public function parse(): array;
}
