<?php

namespace Nurmanhabib\QuotaTool;

class Limit
{
    protected $type;
    protected $current;
    protected $quota; // or soft limit
    protected $limit; // or hard limit

    public function __construct($quota = 10000, $limit = 10240, $current = 0, $type = 'block')
    {
        $this->type     = $type;
        $this->current  = $current;
        $this->quota    = $quota;
        $this->limit    = $limit;
    }

    public function option()
    {
        return '-' . substr($this->type, 0, 1);
    }

    public function type($value = null)
    {
        if ($value && $value == 'inode')
            $this->type = $value;
        else
            return $this->type;

        return $this;
    }

    public function current($value = null)
    {
        if ($value)
            $this->current = $value;
        else
            return $this->current;

        return $this;
    }

    public function quota($value = null)
    {
        if ($value)
            $this->quota = $value;
        else
            return $this->quota;

        return $this;
    }

    public function limit($value = null)
    {
        if ($value)
            $this->limit = $value;
        else
            return $this->limit;

        return $this;
    }

    public function raw()
    {
        $raw = $this->option() . ' -q ' . $this->quota . ' -l ' . $this->limit;

        return $raw;
    }

    public function toArray()
    {
        return [
            'type'      => $this->type(),
            'current'   => $this->current(),
            'quota'     => $this->quota(),
            'limit'     => $this->limit(),
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function __toString()
    {
        return $this->toJson();
    }
}