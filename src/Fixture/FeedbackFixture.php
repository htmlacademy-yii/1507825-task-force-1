<?php


namespace TaskForce\Fixture;


use TaskForce\Tool\Data\Helper\EndlessConnection;
use TaskForce\Tool\Data\Helper\RandomRecordSearcher;

class FeedbackFixture extends Base implements ILogFixture
{

    public function getSql(): string
    {
        $tableName = 'feedback';

        $mapping = [
            [
                'sql_field' => 'created_at',
                'data_field' => 'dt_add',
                'sql_type' => 'date'
            ],
            [
                'sql_field' => 'grade',
                'data_field' => 'rate',
                'sql_type' => 'integer'
            ],
            [
                'sql_field' => 'text',
                'data_field' => 'description',
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

        return $this->readCsvAsSql($this->filePath, $tableName, $mapping, static function($feedback) use ($searcher){
            $task = $searcher->getOne('task');
            $user = $searcher->getOne('user');

            $feedback['task'] = $task['id'];
            $feedback['user'] = $user['id'];

            return $feedback;
        });
    }

    public function getWholeSql(): string
    {
        return $this->getSql();
    }
}
