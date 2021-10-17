<?php

declare(strict_types=1);

/*
 * This file is part of the slince/spike package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spike\Connection;

use React\Promise\PromiseInterface;
use React\Socket\ConnectionInterface as RawConnection;
use Spike\Command\CommandInterface;
use Spike\Protocol\Message;
use Spike\Protocol\MessageParser;

class StreamConnection implements ConnectionInterface
{
    /**
     * @var RawConnection
     */
    protected $stream;

    public function __construct(RawConnection $stream)
    {
        $this->stream = $stream;
    }

    /**
     * {@inheritdoc}
     */
    public function getRemoteAddress(): string
    {
        return $this->stream->getRemoteAddress();
    }

    /**
     * {@inheritdoc}
     */
    public function getLocalAddress(): string
    {
        return $this->stream->getLocalAddress();
    }

    /**
     * {@inheritdoc}
     */
    public function disconnect(bool $force = false)
    {
        $force ? $this->stream->close() : $this->stream->end();
    }

    /**
     * {@inheritdoc}
     */
    public function executeCommand(CommandInterface $command)
    {
        $this->writeRequest($command);
    }

    /**
     * {@inheritdoc}
     */
    public function writeRequest(CommandInterface $command)
    {
        $message = $command->createMessage();
        $message->addArgument('_cid_', $command->getCommandId());
        $message = Message::pack($message);
        $this->stream->write($message);
    }

    /**
     * {@inheritdoc}
     */
    public function listenRaw(callable $callback)
    {
        $this->stream->on('data', $callback);
    }

    /**
     * {@inheritdoc}
     */
    public function listen(callable $callback)
    {
        $parser = new MessageParser($this);
        $parser->on('message', $callback);
        $parser->parse();
    }

    /**
     * @return RawConnection
     */
    public function getStream(): RawConnection
    {
        return $this->stream;
    }
}