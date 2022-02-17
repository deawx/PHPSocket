<?php
/**
 * Client.php
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

use PHPSocket\Classes\Sockets;
use PHPSocket\Exception\SocketConnectException;

class Client extends Sockets implements \PHPSocket\Interfaces\ClientInterface
{

    public function __construct($host, $port, $domain)
    {
        $socket = $this->createSocketSource('tcp', \SOCK_STREAM, $domain);
        if(\socket_connect($socket, $host, $port) === FALSE){
            throw new SocketConnectException('Socket Connection Error : ' . $this->getLastError());
        }
        $this->socket = $socket;
    }

    public function read(int $length, int $type = \PHP_BINARY_READ)
    {
        return \socket_read($this->socket, $length, $type);
    }

    public function write(string $content)
    {
        return \socket_write($this->socket, $content, \strlen($content));
    }

    public function close()
    {
        \socket_close($this->socket);
    }

}
