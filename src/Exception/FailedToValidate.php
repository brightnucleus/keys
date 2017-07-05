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

namespace BrightNucleus\Keys\Exception;

use BrightNucleus\Exception\RangeException;
use BrightNucleus\Validation\Exception\ValidationException;

/**
 * Class FailedToValidate.
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Key\Exception
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class FailedToValidate extends RangeException implements KeyException, ValidationException
{
    /**
     * Instantiate a new exception for a given value that does not validate for a specific class.
     *
     * @since 0.1.0
     *
     * @param mixed  $value Value that does not validate.
     * @param string $class FQCN of the class that failed to validate the value.
     *
     * @return static
     */
    public static function fromValueForClass($value, $class)
    {
        $message = sprintf(
            'Failed to validate value "%1$s" to be used as a key instance of %2$s.',
            $value,
            $class
        );

        return new static($message);
    }
}
