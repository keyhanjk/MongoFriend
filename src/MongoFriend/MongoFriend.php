<?php

namespace MongoFriend;

use MongoDB\Client as MongoDBClient;

class MongoFriend
{
    private $_config;
    public function __construct(array $config)
    {
        $this->_config = $config;
    }

    public function table(string $name): MongoFriendTable
    {
        $collection = (new MongoDBClient)->selectDatabase($this->_config['dbname'])->selectCollection($name);

        return new MongoFriendTable($collection);
    }
}
