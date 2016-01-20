<?php

namespace Instante\Tests\Utils\Nette;

use Instante\Utils\Nette\ObjectEvents;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

class Evt
{
    use ObjectEvents;

    public $onFoo = [];
    public static $processed = FALSE;
}

$x = new Evt;
$x->onFoo[] = function ($arg) {
    if ($arg === 'foo') {
        Evt::$processed = TRUE;
    }
};
Assert::false(Evt::$processed);
$x->onFoo('foo');
Assert::true(Evt::$processed);
