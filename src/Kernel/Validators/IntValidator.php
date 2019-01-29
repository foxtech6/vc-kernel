<?php

namespace Foxtech\Kernel\Validators;

/**
 * Class IntValidator
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 29.01.2019
 */
class IntValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     * @see ValidatorInterface::validate()
     */
    public function validate($value, string $name, string $rule): ?string
    {
        if (false !== strpos($value, '.') || !is_numeric($value)) {
            return 'Param ' . $name . ' is not int';
        }

        return null;
    }
}
