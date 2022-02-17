<?php
/**
 * Connection.php
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

namespace PHPSocket;

use PHPSocket\Exception\PHPSocketException;
use PHPSocket\Interfaces\ClientInterface;
use PHPSocket\Interfaces\ServerInterface;

class Connection
{

    private static $protocols = [
        'TCP', 'UDP', 'SSL', 'TLS'
    ];

    /**
     * @param string $type
     * @param string $protocol
     * @param string $host
     * @param int $port
     * @param $parameters
     * @return ClientInterface|ServerInterface
     * @throws PHPSocketException
     */
    protected static function connection(string $type, string $protocol, string $host, int $port, $parameters)
    {
        $protocol = \strtoupper($protocol);
        if(!\in_array($protocol, self::$protocols, true)){
            throw new PHPSocketException('PHPSocket only supports the following protocols; ' . \implode(', ', self::$protocols));
        }
        $type = \ucfirst(\strtolower($type));
        $class = 'PHPSocket\\' . $protocol . '\\' . $type;
        return new $class($host, $port, $parameters);
    }

}
