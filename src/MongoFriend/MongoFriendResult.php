<?php

namespace MongoFriend;

class MongoFriendResult
{
    private $_docs;
    private $_resultType;

    public function __construct(string $resultType, $result)
    {
        $this->_resultType = $resultType;
        $this->_docs = $result;
    }

    public function limit(int $count = 1): MongoFriendResult
    {
        $this->_docs->limit($count);
        return $this;
    }

    public function offset(int $offset = 0): MongoFriendResult
    {
        $this->_docs->skip($offset); ////offset
        return $this;
    }

    public function sort(array $rules): MongoFriendResult
    {
        $this->_docs->sort($rules);
        return $this;
    }

    public function display()
    {
        foreach ($this->_docs as $doc) {
            printf("%s\n", $doc['_id']);
        }
    }
}
