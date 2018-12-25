<?php

namespace MongoFriend;

use MongoDB\Collection as MongoDBCollection;

class MongoFriendTable
{
    private $_collection;
    private $_query = [];

    public function __construct(MongoDBCollection $collection)
    {
        $this->_collection = $collection;
    }

    public function add(array $data): string
    {
        $result = $this->_collection->insertOne($data);
        return (string) $result->getInsertedId();
    }

    public function find(array $where = []): MongoFriendResult
    {
        return new MongoFriendResult("find", $this->_collection->find($where));
    }

    public function update(array $where = []): MongoFriendResult
    {
        return new MongoFriendResult("update", $this->_collection->update($where));
    }

    public function delete(array $where = []): MongoFriendResult
    {
        return new MongoFriendResult("delete", $this->_collection->delete($where));
    }

}
