<?php


namespace TaskForce\Fixture;


class CityFixture extends Base implements ILogFixture
{

    public function getSql(): string
    {
        $tableName = 'city';

        $mapping = [
            [
                'sql_field' => 'name',
                'data_field' => 'city',
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
