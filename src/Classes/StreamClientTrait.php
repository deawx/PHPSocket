<?php
/**
 * StreamClientTrait.php
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
use PHPSocket\Exception\SocketConnectException;

trait StreamClientTrait
{

    public function __construct($host, $port, $timeout)
    {
        $address = $this->type . '://' . $host . ':' . $port;
        $socket = \stream_socket_client($address, $errNo, $errStr, $timeout, \STREAM_CLIENT_CONNECT, \stream_context_create(['ssl' => $this->options]));
        if($errStr){
            throw new SocketConnectException($errStr);
        }
        $this->socket = $socket;
    }

    public function crypto(string $method = null): self
    {
        if(empty($method)){
            \stream_socket_enable_crypto($this->socket, false);
            return $this;
        }
        $method = strtolower($method);
        $algos = [
            'sslv2'   => \STREAM_CRYPTO_METHOD_SSLv2_CLIENT,
            'sslv3'   => \STREAM_CRYPTO_METHOD_SSLv3_CLIENT,
            'sslv23'  => \STREAM_CRYPTO_METHOD_SSLv23_CLIENT,
            'any'     => \STREAM_CRYPTO_METHOD_ANY_CLIENT,
            'tls'     => \STREAM_CRYPTO_METHOD_TLS_CLIENT,
            'tlsv1.0' => \STREAM_CRYPTO_METHOD_TLSv1_0_CLIENT,
            'tlsv1.1' => \STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT,
            'tlsv1.2' => \STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
        ];
        if(!isset($algos[$method])){
            throw new PHPSocketException('Unsupported crypto method. This library supports: ' . \implode(', ', \array_keys($algos)));
        }
        \stream_socket_enable_crypto($this->socket, true, $algos[$method]);
        return $this;
    }

    public function blocking(bool $mode = true): self
    {
        \stream_set_blocking($this->socket, $mode);
        return $this;
    }

    public function timeout(int $timeout): self
    {
        \stream_set_timeout($this->socket, $timeout);
        return $this;
    }

    /**
     * @param int $length
     * @return false|string
     */
    public function read(int $length = 1024)
    {
        return \fread($this->socket, $length);
    }

    public function write(string $content)
    {
        return \fwrite($this->socket, $content, \strlen($content));
    }

    public function close()
    {
        \fclose($this->socket);
    }

}
