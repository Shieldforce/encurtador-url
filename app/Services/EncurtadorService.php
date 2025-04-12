<?php

namespace App\Services;

class EncurtadorService
{
    protected string $destiny;
    protected string $hash;

    public function __construct(public string $origin) {}

    public function handle()
    {
        $newUrl = md5($this->origin);

        $newUrl = substr($newUrl, 0, 8);

        $this->setHash($newUrl);

        $this->setDestiny(config("app.url") . "/{$newUrl}");
    }

    private function setDestiny(string $destiny): void
    {
        $this->destiny = $destiny;
    }

    public function getDestiny(): string
    {
        return $this->destiny;
    }

    private function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
