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

namespace PHPSocket\TLS;

use PHPSocket\Classes\StreamClientTrait;
use PHPSocket\Classes\StreamSocket;

class Client extends StreamSocket implements \PHPSocket\Interfaces\ClientInterface
{

    use StreamClientTrait;

    protected string $type = 'tls';

}
