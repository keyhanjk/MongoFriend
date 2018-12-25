<?php

namespace MongoFriend;

class MongoFriendTable
{
    private $_collection;
    public function __construct($collection)
    {
        $this->_collection = $collection;
    }

    public function add($data)
    {
        $result = $this->_collection->insertOne($data);
        return (string) $result->getInsertedId();
    }

    public function update($name)
    {

    }

    public function delete($name)
    {

    }

    public function find($name)
    {

    }
}
