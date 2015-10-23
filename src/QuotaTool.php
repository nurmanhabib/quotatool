<?php

namespace Nurmanhabib\QuotaTool;

use Symfony\Component\Process\Process;

class QuotaTool
{
    protected $ugid;
    protected $limit;
    protected $filesystem;
    protected $dump_data;
    protected $command;
    protected $response;

    public function __construct($filesystem = '/home', $command = 'sudo quotatool')
    {
        $this->ugid         = new UserGroup;
        $this->limit        = new Limit;
        $this->filesystem   = $filesystem;
        $this->command      = $command;
        $this->response     = '';
    }

    public function uid($uid)
    {
        $this->ugid = new Uid($uid);

        return $this;
    }

    public function gid($gid)
    {
        $this->ugid = new Gid($gid);

        return $this;
    }

    public function limit($quota, $limit = null, $type = 'block')
    {
        if ($quota instanceof Limit) {
            $this->limit = $quota;
        } else {
            $limit = $limit ?: $quota;

            if ($type == 'inode')
                $this->limit = new LimitInode($quota, $limit);
            else
                $this->limit = new LimitBlock($quota, $limit);
        }

        return $this;
    }

    public function filesystem($filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    public function limitBlock($soft, $hard)
    {
        $this->limit($soft, $hard);

        return $this;
    }

    public function limitInode($soft, $hard)
    {
        $this->limit($soft, $hard, 'inode');

        return $this;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function raw()
    {
        $raw = $this->command . ' ' . $this->ugid->raw() . ' ' . $this->limit->raw() . ' ' . $this->filesystem;
        
        return $raw;
    }

    public function run()
    {
        $process = new Process($this->raw());
        $process->run();

        if ($process->isSuccessful()) {
            $this->reponse = $process->getOutput();

            return true;
        } else {
            $this->response = $process->getErrorOutput();

            return false;
        }
    }

    public function response()
    {
        return $this->response;
    }
}