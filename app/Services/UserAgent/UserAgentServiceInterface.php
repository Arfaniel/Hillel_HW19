<?php

namespace App\Services\UserAgent;

interface UserAgentServiceInterface
{
    public function parse(string $userAgentString): void;

    public function getBrowser(): ?string;

    public function getOs(): ?string;
}
