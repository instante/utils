<?php

namespace Instante\Tests\Helpers;

use Instante\Helpers\ArrayHelper;
use Instante\Helpers\MissingValueException;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';


class ArrayHelperTest extends TestCase
{
    public function testCreateKeyMap()
    {
        $foo = ['foo' => 'bar', 'id' => 'x', 'name' => 'Iks'];
        $data = [
            (object)$foo,
            (object)['foo' => 'baz', 'id' => 'y', 'name' => 'Ypsilon'],
            (object)['foo' => 'bazaar', 'id' => 'z', 'name' => 'Zet'],
        ];
        Assert::equal(
            ['Iks' => 'bar', 'Ypsilon' => 'baz', 'Zet' => 'bazaar'],
            ArrayHelper::createKeyMap($data, 'foo', 'name'),
            'Creating key map from custom key/value fields');
        Assert::equal(
            ['x' => 'Iks', 'y' => 'Ypsilon', 'z' => 'Zet'],
            ArrayHelper::createKeyMap($data),
            'Creating key map from default key=id,value=name fields');
        Assert::equal(
            ['x' => 'Iks'],
            ArrayHelper::createKeyMap([$foo]),
            'Creating key map from list of assoc arrays');
    }

    public function testFetchValues()
    {
        $foo = new Foo;
        ArrayHelper::fetchValues($foo, ['foo' => 'F', 'bar' => 'B']);
        Assert::same('F', $foo->foo, 'Value fetched into public property');
        Assert::same('B', $foo->getBar(), 'Value fetched into a setter');
    }

    public function testTraversableMap()
    {
        Assert::same(NULL, ArrayHelper::traversableMap(NULL, function () { }),
            'traversableMap should return NULL when passed traversable is NULL');
        Assert::exception(function () {
            ArrayHelper::traversableMap('z', function () {
            });
        }, 'Nette\InvalidArgumentException');
        $data = ['x' => 'Iks', 'y' => 'Ypsilon', 'z' => 'Zed'];
        Assert::equal(['X' => 'I', 'Y' => 'Y', 'Z' => 'Z'], ArrayHelper::traversableMap($data, function ($val, &$key) {
            $key = strtoupper($key);
            return substr($val, 0, 1);
        }), 'mapping an associative array');
    }

    public function testTranslateValues()
    {
        Assert::same(NULL, ArrayHelper::translateValues(NULL, []),
            'translateValues should return NULL when passed traversable is NULL');
        $dict = ['wo' => 'World', 'he' => 'Hello', 'ba' => 'Bar'];
        Assert::equal([], ArrayHelper::translateValues([], $dict));
        Assert::equal(['Hello', 'World'], ArrayHelper::translateValues(['he', 'wo'], $dict));
        Assert::equal(['Hello', 'there', 'World'], ArrayHelper::translateValues(['he', 'there', 'wo'], $dict, TRUE));
        Assert::exception(function () use ($dict) {
            ArrayHelper::translateValues(['he', 'there', 'wo'], $dict);
        }, MissingValueException::class);
    }
}

class Foo
{
    public $foo;
    private $bar;

    /**
     * @return mixed
     */
    public function getBar()
    {
        return $this->bar;
    }

    /**
     * @param mixed $bar
     */
    public function setBar($bar)
    {
        $this->bar = $bar;
    }
}

run(new ArrayHelperTest());




