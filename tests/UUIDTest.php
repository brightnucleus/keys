<?php
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
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid as RamseyUUID;

/**
 * Class UUIDTest.
 *
 * @since  0.1.0
 *
 * @author Alain Schlesser <alain.schlesser@gmail.com>
 */
final class UUIDTest extends TestCase
{

    const TEST_UUID = '63ab6383-0ad4-559a-b16b-afcec9cc77e9';
    const SERIALIZED_UUID = 'C:23:"BrightNucleus\Keys\UUID":44:{s:36:"63ab6383-0ad4-559a-b16b-afcec9cc77e9";}';
    const JSON_TEST_UUID = '"63ab6383-0ad4-559a-b16b-afcec9cc77e9"';
    const TEST_URL1 = 'https://www.brightnucleus.com';
    const TEST_URL2 = 'https://www.alainschlesser.com';

    /**
     * Test whether the class can be instantiated.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_can_be_instantiated()
    {
        $uuid   = $this->createMock(UuidInterface::class);
        $object = new UUID($uuid);
        $this->assertInstanceOf(UUID::class, $object);
    }

    /**
     * Test whether the class can instantiated as a UUID v1.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_can_be_created_as_v1()
    {
        $object = UUID::uuid1();
        $this->assertInstanceOf(UUID::class, $object);
        $this->assertEquals(1, $object->getVersion());
    }

    /**
     * Test whether the class can instantiated as a UUID v3.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_can_be_created_as_v3()
    {
        $object = UUID::uuid3(RamseyUUID::NAMESPACE_URL, self::TEST_URL1);
        $this->assertInstanceOf(UUID::class, $object);
        $this->assertEquals(3, $object->getVersion());
    }

    /**
     * Test whether the class can instantiated as a UUID v4.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_can_be_created_as_v4()
    {
        $object = UUID::uuid4();
        $this->assertInstanceOf(UUID::class, $object);
        $this->assertEquals(4, $object->getVersion());
    }

    /**
     * Test whether the class can instantiated as a UUID v5.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_can_be_created_as_v5()
    {
        $object = UUID::uuid5(RamseyUUID::NAMESPACE_URL, self::TEST_URL1);
        $this->assertInstanceOf(UUID::class, $object);
        $this->assertEquals(5, $object->getVersion());
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
        $object     = UUID::uuid5(RamseyUUID::NAMESPACE_URL, self::TEST_URL1);
        $serialized = serialize($object);
        $this->assertEquals(self::SERIALIZED_UUID, $serialized);
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
        $serialized = self::SERIALIZED_UUID;
        $object     = unserialize($serialized);
        $this->assertInstanceOf(UUID::class, $object);
        $this->assertTrue(Uuid::isValid($object));
        $this->assertEquals(5, $object->getVersion());
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
        $serialized = self::SERIALIZED_UUID;
        $object     = unserialize($serialized);
        $serialized = json_encode($object);
        $this->assertEquals(self::JSON_TEST_UUID, $serialized);
    }

    /**
     * Test whether the class can instantiated as a UUIDv1.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_produces_different_uuid1s_on_subsequent_calls()
    {
        $object1 = UUID::uuid1();
        $object2 = UUID::uuid1();
        $this->assertFalse($object1->equals($object2));
        $this->assertNotEquals($object1, $object2);
        $this->assertNotEquals((string)$object1, (string)$object2);
    }

    /**
     * Test whether it produces the same UUIDv3 objects on subsequent calls with the same arguments.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_produces_same_uuid3s_on_subsequent_calls_with_same_arguments()
    {
        $object1 = UUID::uuid3(RamseyUUID::NAMESPACE_URL, self::TEST_URL1);
        $object2 = UUID::uuid3(RamseyUUID::NAMESPACE_URL, self::TEST_URL1);
        $this->assertTrue($object1->equals($object2));
        $this->assertEquals($object1, $object2);
        $this->assertEquals((string)$object1, (string)$object2);
    }

    /**
     * Test whether it produces different UUIDv3 objects on subsequent calls with differing arguments.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_produces_different_uuid3s_on_subsequent_calls_with_differing_arguments()
    {
        $object1 = UUID::uuid3(RamseyUUID::NAMESPACE_URL, self::TEST_URL1);
        $object2 = UUID::uuid3(RamseyUUID::NAMESPACE_URL, self::TEST_URL2);
        $this->assertFalse($object1->equals($object2));
        $this->assertNotEquals($object1, $object2);
        $this->assertNotEquals((string)$object1, (string)$object2);
    }

    /**
     * Test whether the class can instantiated as a UUIDv4.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_produces_different_uuid4s_on_subsequent_calls()
    {
        $object1 = UUID::uuid4();
        $object2 = UUID::uuid4();
        $this->assertFalse($object1->equals($object2));
        $this->assertNotEquals($object1, $object2);
        $this->assertNotEquals((string)$object1, (string)$object2);
    }

    /**
     * Test whether it produces the same UUIDv5 objects on subsequent calls with the same arguments.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_produces_same_uuid5s_on_subsequent_calls_with_same_arguments()
    {
        $object1 = UUID::uuid5(RamseyUUID::NAMESPACE_URL, self::TEST_URL1);
        $object2 = UUID::uuid5(RamseyUUID::NAMESPACE_URL, self::TEST_URL1);
        $this->assertTrue($object1->equals($object2));
        $this->assertEquals($object1, $object2);
        $this->assertEquals((string)$object1, (string)$object2);
    }

    /**
     * Test whether it produces different UUIDv5 objects on subsequent calls with differing arguments.
     *
     * @since 0.1.0
     *
     * @test
     */
    public function it_produces_different_uuid5s_on_subsequent_calls_with_differing_arguments()
    {
        $object1 = UUID::uuid5(RamseyUUID::NAMESPACE_URL, self::TEST_URL1);
        $object2 = UUID::uuid5(RamseyUUID::NAMESPACE_URL, self::TEST_URL2);
        $this->assertFalse($object1->equals($object2));
        $this->assertNotEquals($object1, $object2);
        $this->assertNotEquals((string)$object1, (string)$object2);
    }
}
