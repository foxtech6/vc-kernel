<?php

namespace Foxtech\Kernel\Validators;

/**
 * Class RequiredValidator
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 29.01.2019
 */
class RequiredValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     * @see ValidatorInterface::validate()
     */
    public function validate($value, string $rule): ?string
    {
        if (!$value) {
            return 'Param is required';
        }

        return null;
    }
}
