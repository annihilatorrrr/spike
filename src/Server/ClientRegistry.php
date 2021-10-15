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

final class ClientRegistry
{
    /**
     * @var Client[]
     */
    protected $clients = [];

    protected $storage;

    public function __construct()
    {
        $this->storage = new \SplObjectStorage();
    }

    public function add(Client $client)
    {
        $this->clients[$client->getId()] = $client;
        $this->storage->attach($client->getConnection(), $client);
    }

    public function get(string $id): ?Client
    {
        return $this->clients[$id] ?? null;
    }

    public function remove(Client $client)
    {
        $client->getConnection()->disconnect();
        unset($this->clients[$client->getId()]);
        $this->storage->detach($client->getConnection());
    }

    /**
     * Search client that match the connection.
     *
     * @param ConnectionInterface $connection
     * @return Client|null
     */
    public function search(ConnectionInterface $connection): ?Client
    {
        return $this->storage->contains($connection)
            ? $this->storage->offsetGet($connection) : null;
    }
}