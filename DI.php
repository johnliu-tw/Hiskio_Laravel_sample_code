<?php
namespace Database;

class Database
{
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = new MySqlAdapter;
        $this->adapter = $adapter;
    }
}

interface Adapter
{
}

class MySqlAdapter implements Adapter
{
}
class PgSqlAdapter implements Adapter
{
}
