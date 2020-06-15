<?php


namespace TaskForce\Fixture;


use TaskForce\Tool\Data\Csv\Reader;
use TaskForce\Tool\Data\Sql\Converter;

class CategoryFixture extends Base implements ILogFixture
{

    public function getSql(): string
    {
        $filePath = DOCUMENT_ROOT . '/data/categories.csv';
        $tableName = 'category';

        $mapping = [
            [
                'field' => 'name',
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
