<?php

namespace Instante\Tests\Helpers;

use Instante\Helpers\Strings;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

Assert::same('foo', Strings::afterLast('foo', '.'));
Assert::same('foo', Strings::afterLast('foo', ''));
Assert::same('foo', Strings::afterLast('bar.foo', '.'));
Assert::same('foo.foo', Strings::afterLast('bar..foo.foo', '..'));
Assert::same('foo', Strings::afterLast('bar.baz.foo', '.'));
Assert::same('', Strings::afterLast('bar.', '.'));
