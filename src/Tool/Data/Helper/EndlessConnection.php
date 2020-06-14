<?php


namespace TaskForce\Tool\Data\Helper;


use mysqli;

class EndlessConnection
{
    private mysqli $link;

    private string $host;
    private string $user;
    private string $pass;
    private string $dbName;

    public function __construct($host, $user, $pass, $dbName)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbName = $dbName;
        $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbName);
    }

    public function getLink(): mysqli
    {
        return $this->link;
    }

    public function renew(): void {
        if ($this->link){
            $this->link->close();
        }
        $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbName);
    }
}
