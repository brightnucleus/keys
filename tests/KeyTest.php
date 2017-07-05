<?php declare(strict_types=1);
/**
 * Bright Nucleus Keys.
 *
 * Validatable key objects.
 *
 * @package   BrightNucleus\Keys
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      https://www.brightnucleus.com/
 * @copyright 2017 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Keys;

use PHPUnit\Framework\TestCase;

/**
 * Class KeyTest.
 *
 * @since  0.1.0
 *
 * @author Alain Schlesser <alain.schlesser@gmail.com>
 */
final class KeyTest extends TestCase
{

    const TEST_KEY = 'testKey';
    const SERIALIZED_TEST_KEY = 'C:22:"BrightNucleus\Keys\Key":14:{s:7:"testKey";}';
    const JSON_TEST_KEY = '"testKey"';

    /**
     * Test whether the class can be instantiated.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_can_be_instantiated()
    {
        $object = new Key(self::TEST_KEY);
        $this->assertInstanceOf(Key::class, $object);
    }

    /**
     * Test whether the class can be cast to a string.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_can_be_cast_to_string()
    {
        $object = new Key(self::TEST_KEY);
        $this->assertEquals(self::TEST_KEY, (string)$object);
    }

    /**
     * Test whether the class can be serialized.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_can_be_serialized()
    {
        $object     = new Key(self::TEST_KEY);
        $serialized = serialize($object);
        $this->assertEquals(self::SERIALIZED_TEST_KEY, $serialized);
    }

    /**
     * Test whether the class can be unserialized.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_can_be_unserialized()
    {
        $serialized = self::SERIALIZED_TEST_KEY;
        $object     = unserialize($serialized);
        $this->assertInstanceOf(Key::class, $object);
        $this->assertEquals(self::TEST_KEY, (string)$object);
    }

    /**
     * Test whether the class can serialized to JSON.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_can_be_serialized_to_json()
    {
        $object     = new Key(self::TEST_KEY);
        $serialized = json_encode($object);
        $this->assertEquals(self::JSON_TEST_KEY, $serialized);
    }
}
