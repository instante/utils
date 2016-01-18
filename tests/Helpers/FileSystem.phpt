<?php
namespace Instante\Tests\Helpers;

use Instante\Helpers\FileSystem;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

Assert::same('..foo/..bar/.baz/bar../bar.php', FileSystem::simplifyPath('..foo/..bar/.baz/bar../bar.php'));
Assert::same('bar/baz.php', FileSystem::simplifyPath('foo/../bar/baz.php'));
Assert::same('ba/baz.php', FileSystem::simplifyPath('ba/baz/foo/../.././baz.php'));
Assert::same('../../foo', FileSystem::simplifyPath('../../bar/../foo/aa/..'));
Assert::same('/b', FileSystem::simplifyPath('/a/../b'));
Assert::same('/b', FileSystem::simplifyPath('/a//..////b'));
Assert::same('a\\c', FileSystem::simplifyPath('a/b/./.././c', '\\'));