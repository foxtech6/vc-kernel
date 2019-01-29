<?php

namespace Foxtech\Kernel\Validators;

/**
 * Class Float
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 29.01.2019
 */
class FloatValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     * @see ValidatorInterface::validate()
     */
    public function validate($value, string $name, string $rule): ?string
    {
        if (!is_numeric($value)) {
            return 'Param ' . $name . ' is not int';
        }

        return null;
    }
}
