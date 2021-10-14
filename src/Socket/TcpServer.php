<?php

namespace Spike\Socket;

use React\EventLoop\LoopInterface;
use React\Socket\TcpServer as SocketServer;

class TcpServer extends AbstractServer
{
    protected function createSocket(string $address, LoopInterface $loop)
    {
        return new SocketServer($address, $loop, $this->createSocketContext());
    }

    protected function createSocketContext(): array
    {
        return [];
    }
}