<?php

namespace Nurmanhabib\QuotaTool;

class LimitInode extends Limit
{
    public function __construct($limit = 10000, $quota = 10240, $current = 0)
    {
        parent::__construct($limit, $quota, $current, 'inode');
    }
}