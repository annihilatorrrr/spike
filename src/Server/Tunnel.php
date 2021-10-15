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

final class Tunnel
{
    /**
     * @var string
     */
    protected $scheme;

    /**
     * @var int
     */
    protected $port;

    public function __construct(string $scheme, int $port)
    {
        $this->scheme = $scheme;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }
}