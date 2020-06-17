<?php


namespace TaskForce\Fixture;


use TaskForce\Tool\Data\Helper\EndlessConnection;
use TaskForce\Tool\Data\Helper\RandomRecordSearcher;

class TaskFixture extends Base implements ILogFixture
{
    private $statusFilePath;

    public function __construct(EndlessConnection $db, string $filePath, array $additionFiles)
    {
        parent::__construct($db, $filePath);
        if (!isset($additionFiles['status'])){
            throw new \Exception('You should provide path to status data file!');
        }
        $this->statusFilePath = $additionFiles['status'];
    }

    public function run(): void
    {
//        $sql = $this->getTaskStatusSql();
//        $this->db->renew();
//        if ($this->db->getlink()->multi_query($sql)){
//            echo 'Task addition records were inserted!'."\n";
//        } else {
//            echo 'Error: '.$this->db->getlink()->error."\n";
//        }

        $this->db->renew();

        $sql = $this->getSql();
        if ($this->db->getlink()->multi_query($sql)){
            echo 'Task records were inserted!'."\n";
        } else {
            echo 'Error: '.$this->db->getlink()->error."\n";
        }
    }

    public function getSql(): string
    {
        $tableName = 'task';

        $mapping = [
            [
                'sql_field' => 'created_at',
                'data_field' => 'dt_add',
                'sql_type' => 'date'
            ],
            [
                'sql_field' => 'category',
                'data_field' => 'category_id',
                'sql_type' => 'integer'
            ],
            [
                'field' => 'description',
                'sql_type' => 'text'
            ],
            [
                'sql_field' => 'title',
                'data_field' => 'name',
                'sql_type' => 'text'
            ],
            [
                'field' => 'budget',
                'sql_type' => 'float'
            ],
            [
                'sql_field' => 'latitute',
                'data_field' => 'lat',
                'sql_type' => 'float'
            ],
            [
                'sql_field' => 'longitute',
                'data_field' => 'long',
                'sql_type' => 'float'
            ],
            [
                'sql_field' => 'date',
                'data_field' => 'expire',
                'sql_type' => 'date'
            ],
            [
                'field' => 'status',
                'sql_type' => 'integer'
            ],
            [
                'field' => 'client',
                'sql_type' => 'integer'
            ],
            [
                'field' => 'executor',
                'sql_type' => 'integer'
            ],
            [
                'field' => 'city',
                'sql_type' => 'integer'
            ]
        ];

        $searcher = $this->searcher;

        return $this->readCsvAsSql($this->filePath, $tableName, $mapping, static function ($task) use ($searcher){
            $category = $searcher->getOne('category');
            $status = $searcher->getOne('task_status');
            $user1 = $searcher->getOne('user');
            $user2 = $searcher->getOne('user');
            $city = $searcher->getOne('city');

            $task['category_id'] = $category['id'];
            $task['status'] = $status['id'];
            $task['client'] = $user1['id'];
            $task['executor'] = $user2['id'];
            $task['city'] = $city['id'];

            return $task;
        });
    }

    private function getTaskStatusSql(){
        $tableName = 'task_status';

        $mapping = [
            [
                'field' => 'name',
                'sql_type' => 'string'
            ],
        ];

        return $this->readCsvAsSql($this->statusFilePath, $tableName, $mapping);
    }

    public function getWholeSql(): string
    {
        return $this->getSql();
    }
}
