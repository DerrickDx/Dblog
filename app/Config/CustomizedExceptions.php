<?php
namespace App\Config;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class CustomizedExceptions extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}