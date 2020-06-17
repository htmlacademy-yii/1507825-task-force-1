<?php


namespace TaskForce\Fixture;


use TaskForce\Tool\Data\Helper\EndlessConnection;
use TaskForce\Tool\Data\Helper\RandomRecordSearcher;

class AnswerFixture extends Base implements ILogFixture
{

    public function getSql(): string
    {
        $tableName = 'answer';

        $mapping = [
            [
                'sql_field' => 'created_at',
                'data_field' => 'dt_add',
                'sql_type' => 'date'
            ],
            [
                'field' => 'budget',
                'sql_type' => 'float'
            ],
            [
                'field' => 'description',
                'sql_type' => 'string'
            ],
            [
                'field' => 'task',
                'sql_type' => 'integer'
            ],
            [
                'field' => 'user',
                'sql_type' => 'integer'
            ]
        ];

        $searcher = $this->searcher;

        return $this->readCsvAsSql($this->filePath, $tableName, $mapping, static function($answer) use ($searcher){
            $task = $searcher->getOne('task');
            $user = $searcher->getOne('user');

            $answer['task'] = $task['id'];
            $answer['user'] = $user['id'];
            $answer['budget'] = random_int(10, 1000);

            return $answer;
        });
    }

    public function getWholeSql(): string
    {
        return $this->getSql();
    }
}
