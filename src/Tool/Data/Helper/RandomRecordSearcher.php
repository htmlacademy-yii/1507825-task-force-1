<?php


namespace TaskForce\Tool\Data\Helper;


use Exception;

class RandomRecordSearcher
{

    private EndlessConnection $link;

    public function __construct(EndlessConnection $link)
    {
        $this->link = $link;
    }

    /**
     * @param string $tableName
     * @return array|null
     * @throws Exception
     */
    public function getOne(string $tableName): array
    {
        $this->link->renew();
        $tableName = preg_replace('/\s+/', '', $tableName);
        $sql = "SELECT * FROM `$tableName` ORDER BY RAND() LIMIT 1;";

        $arrayResult = null;

        if ($result = $this->link->getLink()->query($sql)){
            $arrayResult = $result->fetch_array();
        }

        if ($arrayResult){
            return $arrayResult;
        }

        throw new Exception('Cant access table "'.$tableName.'" for getting random record!');
    }
}
