<?php


namespace Spike\Server\Handler;

use Spike\Exception\InvalidArgumentException;
use Spike\Io\Message;

class DelegatingHandler implements MessageHandlerInterface
{
    /**
     * @var MessageHandlerInterface[]
     */
    protected $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function handle(Message $message)
    {
        if (false === $loader = $this->resolve($message)) {
            throw new LoaderLoadException($resource, null, 0, null, $type);
        }

        return $loader->load($resource, $type);
    }

    protected function resolve(Message $message)
    {
        switch ($message->getAction()) {
            case 'login':
                $handler = new LoginHandler($server);
                break;
            case 'ping':
                $handler = new PingHandler($server);
                break;
            case 'register_tunnel':
                $handler = new RegisterTunnelHandler($server);
                break;
            case 'register_proxy':
                $handler = new RegisterProxyHandler($server);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Cannot find handler for message type: "%s"',
                    get_class($message)
                ));
        }

        return $handler;
    }
}