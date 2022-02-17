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

namespace PHPSocket\UDP;

use PHPSocket\Classes\ServerTrait;
use PHPSocket\Classes\Sockets;

class Server extends Sockets implements \PHPSocket\Interfaces\ServerInterface
{
    use ServerTrait;

    public function __construct($host, $port, $domain)
    {
        $socket = $this->createSocketSource('udp', \SOCK_DGRAM, $domain);
        $this->socketBind($socket, $host, $port);
        $this->socket = $socket;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @param int $length
     * @param int $type <p>MSG_OBB, MSG_PEEK, MSG_WAITALL or MSG_DONTWAIT</p>
     * @return mixed
     */
    public function read(int $length = 1024, int $type = 0)
    {
        \socket_recvfrom($this->socket, $content, $length, $type, $name, $port);
        return $content;
    }

    /**
     * @param string $content
     * @param int $type <p>MSG_OBB, MSB_EOR, MSG_EOF or MSG_DONTROUTE</p>
     * @return false|int
     */
    public function write(string $content, int $type = 0)
    {
        return \socket_sendto($this->socket, $content, \strlen($content), $type, $this->host, $this->port);
    }

    public function close()
    {
        \socket_close($this->socket);
    }

}
