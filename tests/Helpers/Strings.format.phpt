<?php

namespace Instante\Tests\Helpers;

use Instante\Helpers\Strings;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Assert::same('Lorem ipsum', Strings::format('Lorem ipsum', []));
Assert::same('bar foo baz', Strings::format('bar %(_name-test) baz', ['_name-test' => 'foo']));
Assert::same('05.0000', Strings::format('%(a;07.4f)', ['a' => 5]));
Assert::same('0', Strings::format('%(lorem-ipsum;d)', ['lorem-ipsum' => 'lorem']));
Assert::same('escpae %(foo) baz', Strings::format('escpae %%(foo) baz', []));
Assert::same('noescpae %bar baz', Strings::format('noescpae %%%(foo) baz', ['foo' => 'bar']));
Assert::same('barBAZ', Strings::format('%(foo)%(baz)', ['foo' => 'bar', 'baz' => 'BAZ']));
Assert::same('%% %(foo)', Strings::format('%(z)', ['z' => '%% %(foo)']));
