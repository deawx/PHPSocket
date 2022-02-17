<?php
/**
 * StreamSocket.php
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

class StreamSocket
{
    /** @var resource */
    protected $socket;

    protected array $options = [];

    protected $sslContextOptions = [
        'peerName'              => 'peer_name',
        'verifyPeer'            => 'verify_peer',
        'verifyPeerName'        => 'verify_peer_name',
        'allowSelfSigned'       => 'allow_self_signed',
        'ca'                    => 'cafile',
        'capath'                => 'capath',
        'cert'                  => 'local_cert',
        'pk'                    => 'local_pk',
        'passphrase'            => 'passphrase',
        'commonNameMatch'       => 'CN_match',
        'verifyDepth'           => 'verify_depth',
        'ciphers'               => 'ciphers',
        'capturePeerCert'       => 'capture_peer_cert',
        'capturePeerCertChain'  => 'capture_peer_cert_chain',
        'sniEnable'             => 'SNI_enable',
        'sniServerName'         => 'SNI_server_name',
        'disableCompression'    => 'disable_compression',
        'peerFingerprint'       => 'peer_fingerprint'
    ];

    public function option(string $name, $value): self
    {
        $name = $this->sslContextOptions[$name] ?? $name;
        $this->options[$name] = $value;
        return $this;
    }
}
