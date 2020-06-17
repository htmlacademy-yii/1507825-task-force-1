<?php


namespace TaskForce\Fixture;


use TaskForce\Tool\Data\Helper\EndlessConnection;
use TaskForce\Tool\Data\Helper\RandomRecordSearcher;

class UserFixture extends Base implements ILogFixture
{

    private $roleFilePath;
    private $contactTypeFilePath;
    private $contactFilePath;

    public function __construct(EndlessConnection $db, string $filePath, array $additionFiles)
    {
        parent::__construct($db, $filePath);
        if (!isset($additionFiles['role'])){
            throw new \Exception('You should provide path to role data file!');
        }
        if (!isset($additionFiles['contact_type'])){
            throw new \Exception('You should provide path to contact_type data file!');
        }
        if (!isset($additionFiles['contact'])){
            throw new \Exception('You should provide path to contact data file!');
        }
        $this->roleFilePath = $additionFiles['role'];
        $this->contactTypeFilePath = $additionFiles['contact_type'];
        $this->contactFilePath = $additionFiles['contact'];
    }

    public function getWholeSql(): string
    {
        $queries = [
            $this->getUserRoleSql(),
            $this->getUserContactTypeSql(),
            $this->getUserSql(),
            $this->getUserContactSql()
        ];

        return implode("\n", $queries);
    }

    public function run(): void
    {
        $sql = $this->getSql();
        $this->db->renew();
        if ($this->db->getlink()->multi_query($sql)){
            echo 'User addition records were inserted!'."\n";
        } else {
            echo 'Error: '.$this->db->getlink()->error."\n";
        }

        $this->db->renew();

        $sql = $this->getUserSql();
        if ($this->db->getlink()->multi_query($sql)){
            echo 'User records were inserted!'."\n";
        } else {
            echo 'Error: '.$this->db->getlink()->error."\n";
        }

        $this->db->renew();

        $lastQuery = $this->getUserContactSql();

        if ($this->db->getlink()->multi_query($lastQuery)){
            echo 'User contacts were inserted!'."\n";
        } else {
            echo 'Error: '.$this->db->getlink()->error."\n";
        }
    }

    public function getSql(): string
    {
        $sqlQueries = [
            $this->getUserRoleSql(),
            $this->getUserContactTypeSql(),
        ];

        return implode("\n", $sqlQueries);
    }

    protected function getUserSql(): string
    {
        $tableName = 'user';

        $mapping = [
            [
                'sql_field' => 'first_name',
                'data_field' => 'name1',
                'sql_type' => 'string'
            ],
            [
                'sql_field' => 'last_name',
                'data_field' => 'name2',
                'sql_type' => 'string'
            ],
            [
                'field' => 'email',
                'sql_type' => 'string'
            ],
            [
                'field' => 'password',
                'sql_type' => 'string'
            ],
            [
                'sql_field' => 'created_at',
                'data_field' => 'dt_add',
                'sql_type' => 'date'
            ],
            [
                'field' => 'date_of_birth',
                'sql_type' => 'date',
                'default_value' => date('Y-m-d')
            ],
            [
                'field' => 'user_role',
                'sql_type' => 'integer',
            ],
        ];

        $searcher = $this->searcher;

        return $this->readCsvAsSql($this->filePath, $tableName, $mapping, static function ($record) use ($searcher){
            $nameParts = explode(' ', $record['name']);
            $record['name1'] = $nameParts[0];
            $record['name2'] = $nameParts[1];

            $role = $searcher->getOne('user_role');

            $record['user_role'] = $role['id'];

            unset($record['name']);
            return $record;
        });
    }

    private function getUserRoleSql(): string
    {
        $tableName = 'user_role';

        $mapping = [
            [
                'field' => 'name',
                'sql_type' => 'string'
            ],
        ];

        return $this->readCsvAsSql($this->roleFilePath, $tableName, $mapping);
    }

    private function getUserContactTypeSql(): string
    {
        $tableName = 'user_contact_type';

        $mapping = [
            [
                'field' => 'name',
                'sql_type' => 'string'
            ],
        ];

        return $this->readCsvAsSql($this->contactTypeFilePath, $tableName, $mapping);
    }

    private function getUserContactSql(): string
    {
        $tableName = 'user_contact';

        $mapping = [
            [
                'field' => 'value',
                'sql_type' => 'string'
            ],
            [
                'field' => 'user',
                'sql_type' => 'integer'
            ],
            [
                'field' => 'type',
                'sql_type' => 'integer'
            ]
        ];

        $searcher = $this->searcher;

        return $this->readCsvAsSql($this->contactFilePath, $tableName, $mapping, static function ($contact) use
        ($searcher){
            $user = $searcher->getOne('user');
            $contactType = $searcher->getOne('user_contact_type');
            $contact['user'] = $user['id'];
            $contact['type'] = $contactType['id'];
            return $contact;
        });
    }

}
