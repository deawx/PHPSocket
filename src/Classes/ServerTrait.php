<?php
/**
 * ServerTrait.php
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

trait ServerTrait
{
    /**
     * @param callback $callback
     * @return mixed
     */
    public function live(callable $callback)
    {
        while(true)
        {
            $callback($this);
        }
    }

    public function wait(int $second)
    {
        \sleep($second);
    }

}
