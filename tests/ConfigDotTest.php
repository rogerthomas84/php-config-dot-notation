<?php
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
        ConfigDot::setConfig($config);
        $this->assertFalse(ConfigDot::has('no.such.key'));

        $this->assertTrue(ConfigDot::has('app.name'));
        $this->assertEquals('Foo Bar', ConfigDot::get('app.name'));
        $this->assertTrue(ConfigDot::has('app.version'));
        $this->assertEquals(1, ConfigDot::get('app.version'));

        $this->assertEquals($config, ConfigDot::get());

        ConfigDot::update('app.name', 'Wolf');
        $this->assertEquals('Wolf', ConfigDot::get('app.name'));

        ConfigDot::update('app.version', 2);
        $this->assertEquals(2, ConfigDot::get('app.version'));
    }
}
