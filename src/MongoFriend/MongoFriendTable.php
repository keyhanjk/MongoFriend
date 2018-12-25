<?php

namespace MongoFriend;

class MongoFriendTable
{
    private $_collection;
    private $_query = "query>";
    public function __construct($collection)
    {
        $this->_collection = $collection;
    }

    //insert
    public function add(array $data)
    {
        $result = $this->_collection->insertOne($data);
        return (string) $result->getInsertedId();
    }

    public function find(): MongoFriendTable
    {
        $this->_query .= "find,";
        return $this;
    }

    public function where(string $condition): MongoFriendTable
    {
        $this->_query .= "where,";
        return $this;
    }

    public function limit(int $count, int $offset = 0): MongoFriendTable
    {
        $this->_query .= "limit,";
        return $this;
    }

    public function sort(array $cols): MongoFriendTable
    {
        $this->_query .= "sort,";
        return $this;
    }

    public function either(string $condition): MongoFriendTable
    {
        $this->_query .= "either,";
        return $this;
    }

    public function also(string $condition): MongoFriendTable
    {
        $this->_query .= "also,";
        return $this;
    }

    public function result(): MongoFriendResult
    {
        $result = $this->_collection->find([
            "firstname" => "keyhan",
        ]);

        // $this->_query .= "find,";
        // return $this->_query;
        return new MongoFriendResult($result);
    }

    public function update($name)
    {
        // if ( func_num_args() > 0 ){
        //     var_dump(func_get_args());
        // }
    }

    public function delete($name)
    {

    }
}
