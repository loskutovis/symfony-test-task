<?php
namespace Itransition\ImportBundle\Service;

use parseCSV;

/**
 * Class CsvParser
 * @package AppBundle\Service
 */
class CsvParser implements AbstractParser
{
    /**
     * @var parseCSV
     */
    private $instance;

    public function __construct(string $path)
    {
        $this->instance = new parseCSV($path);
    }

    /**
     * Returns data from the file
     *
     * @return array
     */
    public function parse(): array
    {
        return $this->instance->data;
    }
}
