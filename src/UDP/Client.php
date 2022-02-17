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

namespace PHPSocket\UDP;

use PHPSocket\Classes\Sockets;
use PHPSocket\Exception\SocketConnectException;

class Client extends Sockets implements \PHPSocket\Interfaces\ClientInterface
{

    public function __construct($host, $port, $domain)
    {
        $socket = $this->createSocketSource('udp', \SOCK_DGRAM, $domain);
        if(\socket_connect($socket, $host, $port) === FALSE){
            throw new SocketConnectException('Socket could not be connected. #' . $this->getLastError());
        }
        $this->socket = $socket;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @param int $length
     * @param int $type <p>MSG_OOB, MSG_PEEK, MSG_WAITALL or MSG_DONTWAIT consts</p>
     * @return void
     */
    public function read(int $length = 1024, int $type = 0)
    {
        \socket_recvfrom($this->socket, $content, $length, $type, $name, $port);
    }

    /**
     * @param string $content
     * @param int $type <p>MSG_OOB, MSG_EOR, MSG_EOF or MSG_DONTROUTE consts</p>
     * @return false|int
     */
    public function write(string $content, int $type = 0)
    {
        return \socket_sendto($this->socket, $content, strlen($content), $type, $this->host, $this->port);
    }

    public function close()
    {
        \socket_close($this->socket);
    }
}
