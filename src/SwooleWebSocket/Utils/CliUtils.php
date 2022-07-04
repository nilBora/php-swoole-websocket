<?php
namespace Jtrw\Micro\Poc\Rpc\SwooleWebSocket\Utils;

class CliUtils
{
    public static function e(string $msg): void
    {
        print_r($msg."\033[90G\033[31;1m[ ERROR ]\033[m\n");
    }
    
    public static function s(string $msg): void
    {
        print_r($msg."\033[90G\033[32;1m[ OK ]\033[m\n");
    }
    
    public static function w(string $msg): void
    {
        print_r($msg."\033[90G\033[33;1m[ Warning ]\033[m\n");
    }
    
    public static function i(string $msg): void
    {
        print_r($msg."\033[90G\033[34;1m[ Info ]\033[m\n");
    }
}