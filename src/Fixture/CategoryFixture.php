<?php


namespace TaskForce\Fixture;

class CategoryFixture extends Base implements ILogFixture
{

    public function getSql(): string
    {
        $tableName = 'category';

        $mapping = [
            [
                'field' => 'name',
                'sql_type' => 'string'
            ],
        ];

        return $this->readCsvAsSql($this->filePath, $tableName, $mapping);
    }

    public function getWholeSql(): string
    {
        return $this->getSql();
    }
}
