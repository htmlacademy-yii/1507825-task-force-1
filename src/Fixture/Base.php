<?php

declare(strict_types=1);

namespace TaskForce\Fixture;

use Closure;
use mysqli;
use TaskForce\Tool\Data\Csv\Reader;
use TaskForce\Tool\Data\Helper\EndlessConnection;
use TaskForce\Tool\Data\Helper\RandomRecordSearcher;
use TaskForce\Tool\Data\Sql\Converter;

abstract class Base
{
    protected EndlessConnection $db;
    protected RandomRecordSearcher $searcher;
    protected string $filePath;

    public function __construct(EndlessConnection $db, string $filePath)
    {
        $this->filePath = $filePath;
        $this->db = $db;
        $this->searcher = new RandomRecordSearcher($db);
    }

    public function run(): void
    {
        $sql = $this->getSql();
        $this->db->renew();
        if ($this->db->getlink()->multi_query($sql)){
            echo 'Records were inserted!'."\n";
        } else {
            echo 'Error: '.$this->db->getlink()->error."\n";
        }
    }

    protected function readCsvAsSql($filePath, $tableName, $mapping, Closure $recordProcessor=null): string
    {
        $data = new Reader($filePath);
        $converter = new Converter();

        $processedData = [];
        foreach($data->getRecord() as $record){
            if (empty($record)) continue;

            if ($recordProcessor){
                $record = $recordProcessor($record);
            }

            $processedData[] = $record;
        }

        return $converter->dataToSql($tableName, $mapping, $processedData);
    }

    abstract public function getSql(): string;
}
