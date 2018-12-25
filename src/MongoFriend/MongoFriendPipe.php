<?php

namespace MongoFriend;

class MongoFriendPipe
{
    public function where()
    {
        return this;
    }

    // function  and () {
    //     return this;
    // }

    // function  or () {
    //     return this;
    // }

    public function limit()
    {
        return this;
    }

    public function sort()
    {
        return this;
    }

    public function run()
    {
        return new MongoFriendResult();
    }
}
