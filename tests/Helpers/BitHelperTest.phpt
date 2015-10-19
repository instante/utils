<?php

namespace Instante\Tests\Helpers;

use Instante\Helpers\BitHelper;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';


class BitHelperTest extends TestCase
{
    public function testIntToBinaryString()
    {
        Assert::same(str_pad("\x89\xAB\xCD\xEF", PHP_INT_SIZE, "\0", STR_PAD_LEFT), BitHelper::intToBinaryString(0x89ABCDEF));
    }
    public function testSubBits()
    {
        Assert::same(0, BitHelper::subBits("\0", 0, 8), 'basic test on 0');
        Assert::same(0xFF, BitHelper::subBits("\xFF", 0, 8), 'basic test on FF');
        Assert::same(0b00111010111100, BitHelper::subBits($this->generateBitsString('0001110101111000'), 1, 14), 'more complex bit sequence');
        Assert::same(0b1000000001, BitHelper::subBits(0b1000000001 << (PHP_INT_SIZE * 8 - 17) , 7, 10), 'integer input');
        BitHelper::subBits('lorem ipsum', 1, PHP_INT_SIZE * 8); // should accept ranges up to PHP_INT_SIZE*8 bits
        Assert::exception(function() {
            BitHelper::subBits('lorem ipsum', 1, PHP_INT_SIZE * 8 + 1);
        }, 'Nette\InvalidArgumentException'); // should not accept requested ranges longer than PHP_INT_SIZE*8 bits
        Assert::exception(function() {
            BitHelper::subBits('a', 1, 8);
        }, 'Nette\InvalidArgumentException'); // should not accept ranges out of input string length
        BitHelper::subBits('a', 0, 8); // should accept ranges on boundaries of input string length
        Assert::exception(function() {
            BitHelper::subBits('a', -1, 8);
        }, 'Nette\InvalidArgumentException'); // should not accept ranges out of input string length
    }

    private function generateBitsString($bits)
    {
        $bits = preg_replace('~[^01]~', '', $bits);
        $out = '';
        for ($i = 0; $i < strlen($bits); $i += 8) {
            $byte = str_pad(substr($bits, $i, 8), 8, '0', STR_PAD_RIGHT);
            $out .= chr(base_convert($byte, 2, 10));
        }
        return $out;
    }
}

run(new BitHelperTest);
