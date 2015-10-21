<?php

namespace Instante\Tests\Helpers;

use Instante\Helpers\ArrayHelper;
use Instante\Helpers\MissingValueException;
use Instante\Helpers\SafeGet;
use stdClass;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

class Arr implements \ArrayAccess
{
    public function offsetExists($offset) {}

    public function offsetGet($offset)
    {
        if ($offset === 't') {
            return ['e'=>'foo'];
        }
        return FALSE;
    }

    public function offsetSet($offset, $value) {}

    public function offsetUnset($offset) {}
}

class C {
    function s($x) {
        if ($x === 'tan') {
            return new Arr;
        }
        return FALSE;
    }
}

$i = new stdClass;
$i->n = new C();

Assert::same('foo', SafeGet::exception($i)->n->s('tan')['t']['e']->_);
Assert::same('foo', SafeGet::null($i)->n->s('tan')['t']['e']->_);
Assert::null(SafeGet::null($i)->j->a('v')['a']->_);
Assert::exception(function() use ($i) {
    SafeGet::exception($i)->j->a('v')['a']->_;
}, MissingValueException::class);