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

namespace Spike\Server;

use Spike\Connection\ConnectionInterface;

final class Client
{
    /**
     * id.
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var \DateTimeInterface
     */
    protected $activeAt;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var bool
     */
    protected $isAuthenticated = false;

    /**
     * @var TunnelListenerCollection
     */
    protected $tunnelListeners;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->createdAt = new \DateTime();
        $this->activeAt = new \DateTime();
        $this->id = spl_object_hash($this);
    }

    /**
     * Checks whether the client is authenticated.
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return $this->isAuthenticated;
    }

    /**
     * Sets the control connection for the client.
     *
     * @param ConnectionInterface $connection
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Gets the control connection of the client.
     *
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * Gets the client id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets the id for the client.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Refresh the client
     */
    public function refresh()
    {
        $this->activeAt = new \DateTime();
    }

    /**
     * Gets the active datetime.
     */
    public function getActiveAt()
    {
        return $this->activeAt;
    }

    public function setTunnelListeners(TunnelListenerCollection $tunnelListeners)
    {
        $this->tunnelListeners = $tunnelListeners;
    }

    public function getTunnelListeners(): TunnelListenerCollection
    {
        return $this->tunnelListeners;
    }
}