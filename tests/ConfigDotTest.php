<?php

use ConfigDot\Config;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigDotTest
 */
class ConfigDotTest extends TestCase
{
    public function testSimple()
    {
        $config = [
            'app' => [
                'name' => 'Foo Bar',
                'version' => 1
            ]
        ];
        Config::setConfig($config);
        $this->assertFalse(Config::has('no.such.key'));

        $this->assertTrue(Config::has('app.name'));
        $this->assertEquals('Foo Bar', Config::get('app.name'));
        $this->assertTrue(Config::has('app.version'));
        $this->assertEquals(1, Config::get('app.version'));

        $this->assertEquals($config, Config::get());

        Config::update('app.name', 'Wolf');
        $this->assertEquals('Wolf', Config::get('app.name'));

        Config::update('app.version', 2);
        $this->assertEquals(2, Config::get('app.version'));
    }
}
