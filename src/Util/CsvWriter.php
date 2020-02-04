<?php

namespace App\Util;

class CsvWriter implements WriterInterface
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * CsvReader constructor.
     * @param string $filename
     * @param string $delimiter
     */
    public function __construct(string $filename, string $delimiter = ';')
    {
        $this->filename = $filename;
        $this->delimiter = $delimiter;
    }

    /***
     * @param array $header
     * @param array $data
     * @return string
     */
    public function write(array $header, array $data): string
    {
        if (($handle = fopen($this->filename, 'w')) !== FALSE)
        {
            fputcsv($handle, $header, $this->delimiter);
            foreach ($data as $line) {
                fputcsv($handle, $line, $this->delimiter);
            }
            fclose($handle);
        }

        return $this->filename;
    }
}