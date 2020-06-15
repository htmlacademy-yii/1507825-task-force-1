<?php


namespace TaskForce\Fixture;


use TaskForce\Tool\Data\Helper\EndlessConnection;
use TaskForce\Tool\Data\Helper\RandomRecordSearcher;

class AnswerFixture extends Base implements ILogFixture
{

    private RandomRecordSearcher $searcher;

    public function __construct(EndlessConnection $db)
    {
        parent::__construct($db);
        $this->searcher = new RandomRecordSearcher($db);
    }

    public function getSql(): string
    {
        $filePath = DOCUMENT_ROOT . '/data/replies.csv';
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

        return $this->readCsvAsSql($filePath, $tableName, $mapping, static function($answer) use ($searcher){
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
