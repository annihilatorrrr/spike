<?php

namespace Spike\Console;

use React\EventLoop\LoopInterface;
use React\Stream\WritableResourceStream;
use Spike\Log\AsyncStreamHandler;

final class Utils
{
    /**
     * Create file handler.
     *
     * @param string $file
     * @param int|string $level
     * @param LoopInterface|null $loop
     * @return AsyncStreamHandler
     */
    public static function createLogFileHandler(string $file, $level, LoopInterface $loop = null): AsyncStreamHandler
    {
        $resource = fopen($file, 'a+');
        return Utils::createLogHandler($resource, $level, $loop);
    }

    /**
     * Create log handler.
     *
     * @param resource $resource
     * @param int|string $level
     * @param LoopInterface|null $loop
     * @return AsyncStreamHandler
     */
    public static function createLogHandler($resource, $level, LoopInterface $loop = null): AsyncStreamHandler
    {
        $stream = new WritableResourceStream($resource, $loop);
        return new AsyncStreamHandler($stream, $level);
    }
}