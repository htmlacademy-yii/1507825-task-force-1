<?php


namespace TaskForce\Fixture;


use TaskForce\Tool\Data\Csv\Reader;
use TaskForce\Tool\Data\Sql\Converter;

class CityFixture extends Base implements ILogFixture
{

    public function getSql(): string
    {
        $filePath = DOCUMENT_ROOT . '/data/cities.csv';
        $tableName = 'city';

        $mapping = [
            [
                'sql_field' => 'name',
                'data_field' => 'city',
                'sql_type' => 'string'
            ],
        ];

        return $this->readCsvAsSql($filePath, $tableName, $mapping);
    }

    public function getWholeSql(): string
    {
        return $this->getSql();
    }
}
