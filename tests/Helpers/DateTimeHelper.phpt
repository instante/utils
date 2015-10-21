<?php

namespace Instante\Tests\Helpers;

use Instante\Helpers\DateTimeHelper;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';


class DateTimeHelperTest extends TestCase
{
    public function testParse()
    {
        Assert::same('1999-03-02', DateTimeHelper::parse('2.3.1999')->format('Y-m-d'), 'basic date format parsed');
        Assert::same('1999-03-02', DateTimeHelper::parse('2. 3. 1999')->format('Y-m-d'),
            'spaces in date properly ignored');
    }

}


run(new DateTimeHelperTest);
