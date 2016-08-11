<?php

namespace Instante\Tests\Helpers;

use Instante\Helpers\SecureCallHelper;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class A
{
    public function foo($arg)
    {
        return $arg * 2;
    }

    protected function protect()
    {
        return 'A';
    }

    public static function stat()
    {
        return 'A';
    }
}

$a = new A;
Assert::same(6, SecureCallHelper::tryCall($a, 'foo', 3));
Assert::null(SecureCallHelper::tryCall($a, 'protect'));
Assert::null(SecureCallHelper::tryCall($a, 'stat'));
