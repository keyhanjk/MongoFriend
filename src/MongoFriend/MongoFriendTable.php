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

    /**
     * Undocumented function
     *
     * @param array $filter
     * @param array $options
     * @return void
     */
    public function find(array $filter = [], array $options = [])
    {
        return $this->_collection->find($filter, $options);
    }

    public function update(array $filter = [], array $changes = [])
    {
        return $this->_collection->updateMany($filter, ['$set' => $changes]);
    }

    /**
     * Undocumented function
     *
     * @param array $filter
     * @return void
     */
    public function delete(array $filter = [])
    {
        return $this->_collection->deleteMany($filter);
    }
}
