<?php

declare(strict_types=1);

namespace TaskForce\Tool\Data\Csv;


use Exception;
use Iterator;
use SplFileObject;

class Reader
{
    public const DEFAULT_DELIMITER = ',';

    private string $filePath;
    private array $fileData;

    /**
     * Reader constructor.
     * @param string $filePath
     * @param bool $readNow
     * @throws Exception
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return Iterator
     * @throws Exception
     */
    public function getRecord(): Iterator
    {
        $fileObject = $this->openFile();

        $columns = $fileObject->fgetcsv(self::DEFAULT_DELIMITER);
        $columnCount = count($columns);

        foreach ($columns as &$column){
            $column = trim($column);
        }

        while(!$fileObject->eof()){
            $record = $fileObject->fgetcsv(self::DEFAULT_DELIMITER);
            if (!(count($record) !== $columnCount || count(array_filter($record)) <= 0)){
                yield array_combine($columns, $record);
            }
        }
    }

    /**
     * @return SplFileObject
     * @throws Exception
     */
    protected function openFile(): SplFileObject
    {
        if (!file_exists($this->filePath)) {
            throw new Exception('No such file "' . $this->filePath . '"!');
        }

        $fileObject = null;

        if (!($fileObject = new SplFileObject($this->filePath))) {
            throw new Exception('Error opening file!');
        }

        return $fileObject;
    }

}
