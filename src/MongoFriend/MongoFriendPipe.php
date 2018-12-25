<?php

namespace MongoFriend;

class MongoFriendPipe
{
    public function where()
    {
        return $this;
    }

    public function also()
    {
        return $this;
    }

    public function either()
    {
        return $this;
    }

    public function limit()
    {
        return $this;
    }

    public function sort()
    {
        return $this;
    }

    public function run()
    {
        return new MongoFriendResult();
    }
}
