<?php

class HMAC {
    private $secretKey = '';

    function __construct () 
    {
        $this -> setSecretKey($this -> generateKey());
    }

    function __toString ()
    {
        return $this -> secretKey;
    }

    private function setSecretKey ($generatedKey): void 
    {
        $this -> secretKey = $generatedKey;
    }

    public function getSecretKey (): string 
    {
        return $this -> secretKey;
    }

    private function generateKey(): string 
    {
        $salt = bin2hex(random_bytes(32));
        return $salt;
    }

    public function generateHMAC ($key, $move): string 
    {
        return hash_hmac('sha3-256', $move, $key);
    }
}