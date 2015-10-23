<?php

namespace Nurmanhabib\QuotaTool;

class LimitBlock extends Limit
{
    public function __construct($limit = 10000, $quota = 10240, $current = 0)
    {
        parent::__construct($limit, $quota, $current, 'block');
    }
}