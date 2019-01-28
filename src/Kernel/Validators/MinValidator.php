<?php

namespace Foxtech\Kernel\Validators;

/**
 * Class MinValidator
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 27.01.2019
 */
class MinValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     * @see ValidatorInterface::validate()
     */
    public function validate($value, string $rule): ?string
    {
        $min = substr($rule, strpos($rule, ':') + 1);

        if ($value <= $min) {
            return 'Youre number down ' . $min;
        }

        return null;
    }
}
