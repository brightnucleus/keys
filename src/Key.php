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

use BrightNucleus\Validation\Validatable;
use BrightNucleus\Validation\Exception\ValidationException;
use Serializable;
use JsonSerializable;

/**
 * Class Key.
 *
 * @since  0.1.0
 *
 * @author Alain Schlesser <alain.schlesser@gmail.com>
 */
class Key implements Serializable, JsonSerializable, Validatable
{

    /**
     * Internal storage.
     *
     * @since 0.1.0
     *
     * @var mixed
     */
    protected $data;

    /**
     * Instantiate a Key object.
     *
     * @since 0.1.0
     *
     * @param string $key Key string to instantiate the object with.
     */
    public function __construct(string $key)
    {
        $this->data = $this->validate($key);
    }

    /**
     * Return the validated form of the value.
     *
     * @since 0.1.0
     *
     * @param mixed $value Value to validate.
     *
     * @return mixed Validated value.
     * @throws ValidationException If the value failed to validate.
     */
    public function validate($value)
    {
        return $value;
    }

    /**
     * Check whether a value is valid according to the attached validation rules.
     *
     * @since 0.1.0
     *
     * @param mixed $value Value to check for validity.
     *
     * @return bool Whether the value is valid.
     */
    public static function isValid($value): bool
    {
        return true;
    }

    /**
     * Return the string representation of the key.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->data;
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
        return serialize($this->data);
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
        $this->data = unserialize($serialized, []);
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
