<?php
/**
 * Created by PhpStorm.
 * User: dmytrobudonnyi
 * Date: 20.09.2018
 * Time: 12:15
 */

class DB
{
    protected $connection;

    public function __construct($host, $user, $psw, $db_name)
    {
        $this->connection = new mysqli($host, $user, $psw, $db_name);

        $this->query('SET NAMES UTF8');

        if(mysqli_connect_error())
        {
            throw new Exception('Could not connect to DB' );
        }
    }

    public function query($sql)
    {
        if( !$this->connection) {
            return false;
        }

        $result = $this->connection->query($sql);

        return $result;
    }

    public function escape($str)
    {
        return mysqli_escape_string($this->connection, $str);
    }

    public function insertId()
    {
        return mysqli_insert_id($this->connection);
    }
}