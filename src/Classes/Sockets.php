<?php
/**
 * Sockets.php
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

namespace PHPSocket\Classes;

use PHPSocket\Exception\PHPSocketException;

class Sockets
{
    /** @var resource */
    protected $socket;

    protected string $host;
    protected int $port;

    protected array $domains = [
        'v4'        => \AF_INET,
        'v6'        => \AF_INET6,
        'unix'      => \AF_UNIX,
    ];

    protected function createSocketSource($protocol, $type, $domain)
    {
        $domain = empty($domain) ? 'v4' : $domain;
        $protocol = \getprotobyname($protocol);

        if(!isset($this->domains[$domain])){
            throw new PHPSocketException('PHPSocket resource creation failed! Reason: Invalid domain.');
        }
        return \socket_create($this->domains[$domain], $type, $protocol);
    }

    protected function getLastError(): int
    {
        return \socket_last_error();
    }

    protected function socketBind(&$socket, &$host, &$port)
    {
        if(!\socket_bind($socket, $host, $port)){
            throw new PHPSocketException('SocketBind Error : ' . \socket_last_error());
        }
    }

}
