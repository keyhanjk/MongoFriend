<?php

namespace MongoFriend;

class MongoFriendResult
{
    private $_docs;

    public function __construct($documents)
    {
        $this->_docs = $documents;
    }

    public function display()
    {
        foreach ($this->_docs as $doc) {
            printf("%s\n", $doc['_id']);
        }
    }
}
