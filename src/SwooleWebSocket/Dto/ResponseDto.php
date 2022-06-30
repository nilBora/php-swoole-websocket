<?php

namespace Jtrw\Micro\Poc\Rpc\SwooleWebSocket\Dto;

class ResponseDto
{
    private array $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function toJson(): string
    {
        return json_encode($this->data, JSON_THROW_ON_ERROR, 512);
    }
}