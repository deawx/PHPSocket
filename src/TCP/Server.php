<?php
/**
 * Server.php
 *
 * This file is part of PHPSocket.
 *
 * @author     Muhammet ŞAFAK <info@muhammetsafak.com.tr>
 * @copyright  Copyright © 2022 PHPSocket
 * @license    https://github.com/muhametsafak/PHPSocket/blob/main/LICENSE  MIT
 * @version    1.0
 * @link       https://www.muhammetsafak.com.tr
 */

declare(strict_types=1);

namespace PHPSocket\TCP;

use PHPSocket\Classes\ServerTrait;
use PHPSocket\Classes\Sockets;
use PHPSocket\Exception\PHPSocketException;
use PHPSocket\Exception\SocketListenException;

class Server extends Sockets implements \PHPSocket\Interfaces\ServerInterface
{
    use ServerTrait;

    /** @var resource */
    protected $accept;

    protected int $backlog = 3;

    public function __construct($host, $port, $domain)
    {
        $socket = $this->createSocketSource('tcp', \SOCK_STREAM, $domain);
        $this->socketBind($socket, $host, $port);
        if(\socket_listen($socket, $this->backlog) === FALSE){
            throw new SocketListenException('Socket Listen Error : ' . $this->getLastError());
        }
        if(($accept = \socket_accept($socket)) === FALSE){
            throw new PHPSocketException('Socket Accept Error : ' . $this->getLastError());
        }
        $this->socket = $socket;
        $this->accept = $accept;
    }

    public function read(int $length, int $type = \PHP_BINARY_READ)
    {
        return \socket_read($this->accept, $length, $type);
    }

    public function write(string $content)
    {
        return \socket_write($this->accept, $content, \strlen($content));
    }

    public function close()
    {
        \socket_close($this->accept);
        \socket_close($this->socket);
    }

    public function backlog(int $backlog): self
    {
        $this->backlog = $backlog;
        return $this;
    }

}
