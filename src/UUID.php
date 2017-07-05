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

use Ramsey\Uuid\Converter\NumberConverterInterface;
use Ramsey\Uuid\Exception\UnsupportedOperationException;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid as RamseyUUID;
use DateTime;

/**
 * Class UUID.
 *
 * Represents a universally unique identifier (UUID), according to RFC 4122.
 *
 * This class provides immutable UUID objects (the Uuid class) and the static
 * methods `uuid1()`, `uuid3()`, `uuid4()`, and `uuid5()` for generating version
 * 1, 3, 4, and 5 UUIDs as specified in RFC 4122.
 *
 * If all you want is a unique ID, you should probably call `uuid1()` or `uuid4()`.
 * Note that `uuid1()` may compromise privacy since it creates a UUID containing
 * the computer’s network address. `uuid4()` creates a random UUID.
 *
 * Uses "ramsey/uuid" package behind the scenes.
 *
 * @see    https://github.com/ramsey/uuid
 *
 * @since  0.1.0
 *
 * @author Alain Schlesser <alain.schlesser@gmail.com>
 */
final class UUID extends Key implements UuidInterface
{
    /**
     * When this namespace is specified, the name string is a fully-qualified domain name.
     * @link http://tools.ietf.org/html/rfc4122#appendix-C
     */
    const NAMESPACE_DNS = '6ba7b810-9dad-11d1-80b4-00c04fd430c8';

    /**
     * When this namespace is specified, the name string is a URL.
     * @link http://tools.ietf.org/html/rfc4122#appendix-C
     */
    const NAMESPACE_URL = '6ba7b811-9dad-11d1-80b4-00c04fd430c8';

    /**
     * When this namespace is specified, the name string is an ISO OID.
     * @link http://tools.ietf.org/html/rfc4122#appendix-C
     */
    const NAMESPACE_OID = '6ba7b812-9dad-11d1-80b4-00c04fd430c8';
    
    /**
     * When this namespace is specified, the name string is an X.500 DN in DER or a text output format.
     * @link http://tools.ietf.org/html/rfc4122#appendix-C
     */
    const NAMESPACE_X500 = '6ba7b814-9dad-11d1-80b4-00c04fd430c8';

    /**
     * Instantiate an UUID object.
     *
     * @since 0.1.0
     *
     * @param UuidInterface $uuid UUID data to use.
     */
    public function __construct(UuidInterface $uuid)
    {
        $this->data = $this->validate($uuid);
    }

    /**
     * Creates a UUID from a byte string.
     *
     * @param string $bytes
     *
     * @return Key
     */
    public static function fromBytes($bytes): Key
    {
        return new self(RamseyUUID::getFactory()->fromBytes($bytes));
    }

    /**
     * Creates a UUID from the string standard representation.
     *
     * @param string $name A string that specifies a UUID
     *
     * @return Key
     */
    public static function fromString($name): Key
    {
        return new self(RamseyUUID::getFactory()->fromString($name));
    }

    /**
     * Creates a UUID from a 128-bit integer string.
     *
     * @param string $integer String representation of 128-bit integer
     *
     * @return Key
     */
    public static function fromInteger($integer): Key
    {
        return new self(RamseyUUID::getFactory()->fromInteger($integer));
    }

    /**
     * Check if a string is a valid UUID.
     *
     * @param string $uuid The string UUID to test
     *
     * @return boolean
     */
    public static function isValid($uuid): bool
    {
        return RamseyUUID::isValid($uuid);
    }

    /**
     * Generate a version 1 UUID from a host ID, sequence number, and the current time.
     *
     * @param int|string $node     A 48-bit number representing the hardware address
     *                             This number may be represented as an integer or a hexadecimal string.
     * @param int        $clockSeq A 14-bit number used to help avoid duplicates that
     *                             could arise when the clock is set backwards in time or if the node ID
     *                             changes.
     *
     * @return Key
     */
    public static function uuid1($node = null, $clockSeq = null): Key
    {
        return new self(RamseyUUID::getFactory()->uuid1($node, $clockSeq));
    }

    /**
     * Generate a version 3 UUID based on the MD5 hash of a namespace identifier
     * (which is a UUID) and a name (which is a string).
     *
     * @param string $ns   The UUID namespace in which to create the named UUID
     * @param string $name The name to create a UUID for
     *
     * @return Key
     */
    public static function uuid3($ns, $name): Key
    {
        return new self(RamseyUUID::getFactory()->uuid3($ns, $name));
    }

    /**
     * Generate a version 4 (random) UUID.
     *
     * @return Key
     */
    public static function uuid4(): Key
    {
        return new self(RamseyUUID::getFactory()->uuid4());
    }

    /**
     * Generate a version 5 UUID based on the SHA-1 hash of a namespace
     * identifier (which is a UUID) and a name (which is a string).
     *
     * @param string $ns   The UUID namespace in which to create the named UUID
     * @param string $name The name to create a UUID for
     *
     * @return Key
     */
    public static function uuid5($ns, $name): Key
    {
        return new self(RamseyUUID::getFactory()->uuid5($ns, $name));
    }

    /**
     * Compares this UUID to the specified UUID.
     *
     * The first of two UUIDs is greater than the second if the most
     * significant field in which the UUIDs differ is greater for the first
     * UUID.
     *
     * * Q. What's the value of being able to sort UUIDs?
     * * A. Use them as keys in a B-Tree or similar mapping.
     *
     * @param UuidInterface $other UUID to which this UUID is compared
     *
     * @return int -1, 0 or 1 as this UUID is less than, equal to, or greater than `$uuid`
     */
    public function compareTo(UuidInterface $other)
    {
        return $this->data->compareTo($other);
    }

    /**
     * Compares this object to the specified object.
     *
     * The result is true if and only if the argument is not null, is a UUID
     * object, has the same variant, and contains the same value, bit for bit,
     * as this UUID.
     *
     * @param object $other
     *
     * @return bool True if `$other` is equal to this UUID
     */
    public function equals($other): bool
    {
        return $this->data->equals($other);
    }

    /**
     * Returns the UUID as a 16-byte string (containing the six integer fields
     * in big-endian byte order).
     *
     * @return string
     */
    public function getBytes(): string
    {
        return $this->data->getBytes();
    }

    /**
     * Returns the number converter to use for converting hex values to/from integers.
     *
     * @return NumberConverterInterface
     */
    public function getNumberConverter(): NumberConverterInterface
    {
        return $this->data->getNumberConverter();
    }

    /**
     * Returns the hexadecimal value of the UUID.
     *
     * @return string
     */
    public function getHex(): string
    {
        return $this->data->getHex();
    }

    /**
     * Returns an array of the fields of this UUID, with keys named according
     * to the RFC 4122 names for the fields.
     *
     * * **time_low**: The low field of the timestamp, an unsigned 32-bit integer
     * * **time_mid**: The middle field of the timestamp, an unsigned 16-bit integer
     * * **time_hi_and_version**: The high field of the timestamp multiplexed with
     *   the version number, an unsigned 16-bit integer
     * * **clock_seq_hi_and_reserved**: The high field of the clock sequence
     *   multiplexed with the variant, an unsigned 8-bit integer
     * * **clock_seq_low**: The low field of the clock sequence, an unsigned
     *   8-bit integer
     * * **node**: The spatially unique node identifier, an unsigned 48-bit
     *   integer
     *
     * @return array The UUID fields represented as hexadecimal values
     */
    public function getFieldsHex(): array
    {
        return $this->data->getFieldsHex();
    }

    /**
     * Returns the high field of the clock sequence multiplexed with the variant
     * (bits 65-72 of the UUID).
     *
     * @return string Hexadecimal value of clock_seq_hi_and_reserved
     */
    public function getClockSeqHiAndReservedHex(): string
    {
        return $this->data->getClockSeqHiAndReservedHex();
    }

    /**
     * Returns the low field of the clock sequence (bits 73-80 of the UUID).
     *
     * @return string Hexadecimal value of clock_seq_low
     */
    public function getClockSeqLowHex(): string
    {
        return $this->data->getClockSeqLowHex();
    }

    /**
     * Returns the clock sequence value associated with this UUID.
     *
     * @return string Hexadecimal value of clock sequence
     */
    public function getClockSequenceHex(): string
    {
        return $this->data->getClockSequenceHex();
    }

    /**
     * Returns a PHP `DateTime` object representing the timestamp associated
     * with this UUID.
     *
     * The timestamp value is only meaningful in a time-based UUID, which
     * has version type 1. If this UUID is not a time-based UUID then
     * this method throws `UnsupportedOperationException`.
     *
     * @return DateTime A PHP DateTime representation of the date
     * @throws UnsupportedOperationException If this UUID is not a version 1 UUID
     */
    public function getDateTime(): DateTime
    {
        return $this->data->getDateTime();
    }

    /**
     * Returns the integer value of the UUID, converted to an appropriate number
     * representation.
     *
     * @return mixed Converted representation of the unsigned 128-bit integer value
     */
    public function getInteger()
    {
        return $this->data->getInteger();
    }

    /**
     * Returns the least significant 64 bits of this UUID's 128 bit value.
     *
     * @return string Hexadecimal value of least significant bits
     */
    public function getLeastSignificantBitsHex(): string
    {
        return $this->data->getLeastSignificantBitsHex();
    }

    /**
     * Returns the most significant 64 bits of this UUID's 128 bit value.
     *
     * @return string Hexadecimal value of most significant bits
     */
    public function getMostSignificantBitsHex(): string
    {
        return $this->data->getMostSignificantBitsHex();
    }

    /**
     * Returns the node value associated with this UUID
     *
     * For UUID version 1, the node field consists of an IEEE 802 MAC
     * address, usually the host address. For systems with multiple IEEE
     * 802 addresses, any available one can be used. The lowest addressed
     * octet (octet number 10) contains the global/local bit and the
     * unicast/multicast bit, and is the first octet of the address
     * transmitted on an 802.3 LAN.
     *
     * For systems with no IEEE address, a randomly or pseudo-randomly
     * generated value may be used; see RFC 4122, Section 4.5. The
     * multicast bit must be set in such addresses, in order that they
     * will never conflict with addresses obtained from network cards.
     *
     * For UUID version 3 or 5, the node field is a 48-bit value constructed
     * from a name as described in RFC 4122, Section 4.3.
     *
     * For UUID version 4, the node field is a randomly or pseudo-randomly
     * generated 48-bit value as described in RFC 4122, Section 4.4.
     *
     * @return string Hexadecimal value of node
     * @link http://tools.ietf.org/html/rfc4122#section-4.1.6
     */
    public function getNodeHex(): string
    {
        return $this->data->getNodeHex();
    }

    /**
     * Returns the high field of the timestamp multiplexed with the version
     * number (bits 49-64 of the UUID).
     *
     * @return string Hexadecimal value of time_hi_and_version
     */
    public function getTimeHiAndVersionHex(): string
    {
        return $this->data->getTimeHiAndVersionHex();
    }

    /**
     * Returns the low field of the timestamp (the first 32 bits of the UUID).
     *
     * @return string Hexadecimal value of time_low
     */
    public function getTimeLowHex(): string
    {
        return $this->data->getTimeLowHex();
    }

    /**
     * Returns the middle field of the timestamp (bits 33-48 of the UUID).
     *
     * @return string Hexadecimal value of time_mid
     */
    public function getTimeMidHex(): string
    {
        return $this->data->getTimeMidHex();
    }

    /**
     * Returns the timestamp value associated with this UUID.
     *
     * The 60 bit timestamp value is constructed from the time_low,
     * time_mid, and time_hi fields of this UUID. The resulting
     * timestamp is measured in 100-nanosecond units since midnight,
     * October 15, 1582 UTC.
     *
     * The timestamp value is only meaningful in a time-based UUID, which
     * has version type 1. If this UUID is not a time-based UUID then
     * this method throws UnsupportedOperationException.
     *
     * @return string Hexadecimal value of the timestamp
     * @throws UnsupportedOperationException If this UUID is not a version 1 UUID
     * @link http://tools.ietf.org/html/rfc4122#section-4.1.4
     */
    public function getTimestampHex(): string
    {
        return $this->data->getTimestampHex();
    }

    /**
     * Returns the string representation of the UUID as a URN.
     *
     * @return string
     * @link http://en.wikipedia.org/wiki/Uniform_Resource_Name
     */
    public function getUrn(): string
    {
        return $this->data->getUrn();
    }

    /**
     * Returns the variant number associated with this UUID.
     *
     * The variant number describes the layout of the UUID. The variant
     * number has the following meaning:
     *
     * * 0 - Reserved for NCS backward compatibility
     * * 2 - The RFC 4122 variant (used by this class)
     * * 6 - Reserved, Microsoft Corporation backward compatibility
     * * 7 - Reserved for future definition
     *
     * @return int
     * @link http://tools.ietf.org/html/rfc4122#section-4.1.1
     */
    public function getVariant(): int
    {
        return $this->data->getVariant();
    }

    /**
     * Returns the version number associated with this UUID.
     *
     * The version number describes how this UUID was generated and has the
     * following meaning:
     *
     * * 1 - Time-based UUID
     * * 2 - DCE security UUID
     * * 3 - Name-based UUID hashed with MD5
     * * 4 - Randomly generated UUID
     * * 5 - Name-based UUID hashed with SHA-1
     *
     * Returns null if this UUID is not an RFC 4122 variant, since version
     * is only meaningful for this variant.
     *
     * @return int|null
     * @link http://tools.ietf.org/html/rfc4122#section-4.1.3
     */
    public function getVersion()
    {
        return $this->data->getVersion();
    }

    /**
     * Converts this UUID into a string representation.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->data->toString();
    }

    /**
     * Return the string representation of the key.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function serialize(): string
    {
        return serialize($this->data->toString());
    }

    /**
     * Restore the object from serialized data.
     *
     * @since 0.1.0
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $string     = unserialize($serialized, []);
        $this->data = RamseyUUID::fromString($string);
    }

    /**
     * Return the data that should be serialized to JSON.
     *
     * @since 0.1.0
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->data;
    }
}
