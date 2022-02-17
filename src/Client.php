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

namespace PHPSocket;

use PHPSocket\Interfaces\ClientInterface;

class Client extends Connection
{

    public static function run(string $protocol, string $host, int $port, $parameters = null): ClientInterface
    {
        return self::connection('Client', $protocol, $host, $port, $parameters);
    }

}
