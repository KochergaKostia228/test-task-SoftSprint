<?php

class ResponseApi
{
    public bool $status;
    public ?array $error;
    public ?array $user;

    public function __construct(bool $status, ?array $error = null, ?array $user = null)
    {
        $this->status = $status;
        $this->error = $error;
        $this->user = $user['user'] ?? $user;
    }
}