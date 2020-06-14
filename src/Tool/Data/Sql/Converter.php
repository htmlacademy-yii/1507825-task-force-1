<?php


namespace TaskForce\Tool\Data\Sql;


use Exception;

class Converter
{
    public function dataToSql(string $tableName, array $mapping, array $data): string
    {
        $sql = '';

        foreach ($data as $record){
            $sql .= ($this->arrayToSql($tableName, $mapping, $record) . "\n");
        }

        return $sql;
    }

    /**
     * @param string $tableName
     * @param array $mapping
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function arrayToSql(string $tableName, array $mapping, array $data): string
    {
        $sql = "INSERT INTO $tableName";

        $fields = [];
        $values = [];

        foreach ($mapping as $oneFieldMap){
            $oneFieldMap['data_field'] = isset($oneFieldMap['data_field'])
                ? $oneFieldMap['data_field']
                : $oneFieldMap['field'];
            $oneFieldMap['sql_field'] = isset($oneFieldMap['sql_field'])
                ? $oneFieldMap['sql_field']
                : $oneFieldMap['field'];

            $value = null;
            if (isset($data[$oneFieldMap['data_field']]) && $data[$oneFieldMap['data_field']]){
                $value = $data[$oneFieldMap['data_field']];
            } elseif (isset($oneFieldMap['default_value']) && $oneFieldMap['default_value']){
                $value = $oneFieldMap['default_value'];
            }
            if (!$value){
                continue;
            }

            $fields[] = $oneFieldMap['sql_field'];
            $values[] = $this->covertType($oneFieldMap['sql_type'], $value);
        }

        $sql .= '( `' . implode('`, `', $fields) . '` )';
        $sql .= ' VALUES ( ' . implode(', ', $values) . ' );';

        return $sql;
    }

    /**
     * @param string $type
     * @param $value
     * @return string
     * @throws Exception
     */
    private function covertType(string $type, $value): string
    {
        switch ($type){
            case 'text':
            case 'string':
                return (string) '\''.$value.'\'';
            case 'integer': return (integer) $value;
            case 'float': return (float) $value;
            case 'date': {
                $format = '%Y-%m-%d';
                return "STR_TO_DATE('$value', '$format')";
            }
            default: throw new Exception('No such type');
        }
    }
}
