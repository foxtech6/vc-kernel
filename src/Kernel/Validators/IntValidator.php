<?php

namespace Foxtech\Kernel\Validators;

/**
 * Class IntValidator
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 27.01.2019
 */
class IntValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     * @see ValidatorInterface::validate()
     */
    public function validate($value, string $rule): ?string
    {
        if (!is_int(number_format($value))) {
            return 'Param ' . $value . ' is not int';
        }

        return null;
    }
}
