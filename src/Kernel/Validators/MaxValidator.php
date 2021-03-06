<?php

namespace Foxtech\Kernel\Validators;

/**
 * Class MaxValidator
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 27.01.2019
 */
class MaxValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     * @see ValidatorInterface::validate()
     */
    public function validate($value, string $name, string $rule): ?string
    {
        $max = substr($rule, strpos($rule, ':') + 1);

        if ($value > $max) {
            return 'The ' . $name . ' parameter should be greater than ' . $max;
        }

        return null;
    }
}
