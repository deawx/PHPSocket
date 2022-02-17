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

namespace PHPSocket\SSL;

use PHPSocket\Classes\StreamServerTrait;
use PHPSocket\Classes\StreamSocket;

class Server extends StreamSocket implements \PHPSocket\Interfaces\ServerInterface
{

    use StreamServerTrait;

    protected string $type = 'ssl';

}
