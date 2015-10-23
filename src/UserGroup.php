<?php

namespace Nurmanhabib\QuotaTool;

class UserGroup
{
    protected $id;
    protected $type;

    public function __construct($id = '1000', $type = 'uid')
    {
        $this->id   = $id;
        $this->type = $type;
    }

    public function option()
    {
        return '-' . substr($this->type, 0, 1);
    }

    public function id($value = null)
    {
        if ($value)
            $this->id = $value;
        else
            return $this->id;

        return $this;
    }

    public function type($value = null)
    {
        if ($value && $value == 'gid')
            $this->type = $value;
        else
            return $this->type;

        return $this;
    }

    public function raw()
    {
        $raw = $this->option() . ' ' . $this->id;

        return $raw;
    }

    public function toArray()
    {
        return [
            'id'        => $this->id(),
            'type'      => $this->type(),
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