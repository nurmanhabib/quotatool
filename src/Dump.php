<?php

namespace Nurmanhabib\QuotaTool;

use Symfony\Component\Process\Process;

class Dump
{
    protected $ugid;
    protected $mountpoint;
    protected $block;
    protected $inode;
    protected $command;
    protected $response;

    public function __construct(UserGroup $ugid, $mountpoint = '/home')
    {
        $this->ugid         = $ugid;
        $this->mountpoint   = $mountpoint;
        $this->command      = 'sudo quotatool';
        $this->response     = '';
    }

    public function raw()
    {
        $raw = $this->command . ' ' . $this->ugid->raw() . ' -d ' . $this->mountpoint;

        return $raw;
    }

    public function dumping()
    {
        $response = trim($this->response());
        $response = explode(' ', $response);

        $dumping = [
            'ugid'          => $response[0],
            'mountpoint'    => $response[1],
            'block'         => [
                'current'   => $response[2],
                'quota'     => $response[3],
                'limit'     => $response[4],
                'grace'     => $response[5],
            ],
            'inode'         => [
                'current'   => $response[6],
                'quota'     => $response[7],
                'limit'     => $response[8],
                'grace'     => null,
            ],
        ];

        $this->ugid         = $this->ugid;
        $this->mountpoint   = $dumping['mountpoint'];
        $this->block        = $dumping['block'];
        $this->inode        = $dumping['inode'];
    }

    public function run()
    {
        $process = new Process($this->raw());
        
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->response = $buffer;

                return false;
            } else {
                $this->response = $buffer;

                $this->dumping();

                return true;
            }
        });
    }

    public function response()
    {
        return $this->response;
    }

    public function toArray()
    {
        return [
            'ugid'          => $this->ugid->toArray(),
            'mountpoint'    => $this->mountpoint,
            'block'         => $this->block,
            'inode'         => $this->inode,
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