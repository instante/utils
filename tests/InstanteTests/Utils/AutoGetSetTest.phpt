<?php

namespace InstanteTests\Utils;

use Instante\Utils\AutoGetSet;
use Instante\Utils\StaticClass;
use Nette\Object;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';


class AutoGetSetTest extends TestCase
{
    private $foo;
    /**
     * This method is called before a test is executed.
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->foo = new Foo;
    }

    public function testGetter()
    {
        Assert::same('getme', $this->foo->foo, 'getter works');
    }

    public function testSetter()
    {
        $this->foo->bar = 'B';
        Assert::same('B', $this->foo->showBar(), 'setter works');
    }

    public function testGetterSetterCombination()
    {
        $this->foo->baz = 'Z';
        Assert::same('Z', $this->foo->baz, 'getter/setter combination works');
    }

    public function testExplicitMethodPriority()
    {
        Assert::same('explicit', $this->foo->explicit, 'explicit getter should have higher priority');
        $this->foo->explicit = 'yes';
        Assert::true($this->foo->explicitSetFromOutside, 'explicit getter should have higher priority');
    }

    public function testAccessDenied()
    {
        Assert::exception(function() {
            return $this->foo->bar;
        }, 'Nette\MemberAccessException');
        Assert::exception(function() {
            $this->foo->foo = 'intruder';
        }, 'Nette\MemberAccessException');
    }
}

class Foo extends Object
{
    use AutoGetSet;

    /** @var string @getter */
    private $foo = 'getme';

    /** @var string @setter */
    private $bar;

    /** @var string @getter @setter */
    private $baz;

    /** @var string @getter @setter */
    private $explicit = 'hidden';

    public $explicitSetFromOutside = FALSE;

    function showBar() { return $this->bar; }
    function getExplicit()
    {
        return 'explicit';
    }
    function setExplicit($value)
    {
        $this->explicitSetFromOutside = TRUE;
    }
}


run(new AutoGetSetTest);
