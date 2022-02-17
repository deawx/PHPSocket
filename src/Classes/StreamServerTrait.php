<?php
/**
 * StreamServerTrait.php
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

trait StreamServerTrait
{
    use ServerTrait;

    protected $accept;

    public function __construct($host, $port, $timeout)
    {
        $address = $this->type . '://' . $host . ':' . $port;
        $socket = \stream_socket_server(
            $address, $errNo, $errStr, \STREAM_SERVER_BIND|\STREAM_SERVER_LISTEN,
            \stream_context_create(['ssl' => $this->options])
        );
        if($errStr){
            throw new SocketConnectException($errStr);
        }
        if(empty($timeout)){
            $timeout = (int)\ini_get('default_socket_timeout');
        }
        if(($accept = \stream_socket_accept($socket, $timeout)) === FALSE){
            throw new PHPSocketException($errStr);
        }
        $this->socket = $socket;
        $this->accept = $accept;
    }

    public function crypto(?string $method = null): self
    {
        if(empty($method)){
            \stream_socket_enable_crypto($this->accept, false);
            return $this;
        }
        $method = strtolower($method);
        $algos = [
            'sslv2'   => \STREAM_CRYPTO_METHOD_SSLv2_SERVER,
            'sslv3'   => \STREAM_CRYPTO_METHOD_SSLv3_SERVER,
            'sslv23'  => \STREAM_CRYPTO_METHOD_SSLv23_SERVER,
            'any'     => \STREAM_CRYPTO_METHOD_ANY_SERVER,
            'tls'     => \STREAM_CRYPTO_METHOD_TLS_SERVER,
            'tlsv1.0' => \STREAM_CRYPTO_METHOD_TLSv1_0_SERVER,
            'tlsv1.1' => \STREAM_CRYPTO_METHOD_TLSv1_1_SERVER,
            'tlsv1.2' => \STREAM_CRYPTO_METHOD_TLSv1_2_SERVER
        ];
        if(!isset($algos[$method])){
            throw new PHPSocketException('Unsupported crypto method. This library supports: ' . \implode(', ', \array_keys($algos)));
        }
        \stream_socket_enable_crypto($this->accept, true, $algos[$method]);
        return $this;
    }

    public function blocking(bool $mode = true): self
    {
        \stream_set_blocking($this->accept, $mode);
        return $this;
    }

    public function timeout(int $timeout): self
    {
        \stream_set_timeout($this->accept, $timeout);
        return $this;
    }

    public function read(int $length = 1024)
    {
        return \fread($this->socket, $length);
    }

    public function write(string $content)
    {
        return \fwrite($this->socket, $content, strlen($content));
    }

    public function close()
    {
        \fclose($this->socket);
        \fclose($this->accept);
    }

}
