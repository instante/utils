<?php

namespace Instante\Tests\Utils;

use Instante\Utils\InvalidEnumConstantException;
use Instante\Utils\TEnumerator;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

class Zero
{
    use TEnumerator;
}

class Enum
{
    const A = 'x';
    const B = 2;

    use TEnumerator;
}

Assert::count(0, Zero::getPossibleValues());
Assert::equal(['x', 2], Enum::getPossibleValues());
Assert::true(Enum::isValidValue('x'));
Assert::false(Enum::isValidValue('2'));
Assert::false(Enum::isValidValue('3'));
Assert::exception(function () {
    Enum::assertValidValue('3');
}, InvalidEnumConstantException::class);
Assert::noError(function () {
    Enum::assertValidValue('x');
});
