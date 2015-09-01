<?php

namespace InstanteTests\Utils;

use Instante\Utils\StaticClass;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';


class StaticClassTest extends TestCase
{
    public function testDisabledInstantiation()
    {
        Assert::exception(function() {
            $x = new Foo;
        }, 'Nette\StaticClassException');
    }

}

class Foo
{
    use StaticClass;
}


run(new StaticClassTest);
