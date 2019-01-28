<?php

namespace Foxtech\Kernel\Validators;

/**
 * Interface ValidatorInterface
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 27.01.2019
 */
interface ValidatorInterface
{
    /**
     * Validate for parameter
     *
     * @param mixed  $value Parameter value
     * @param string $rule  Rule for parameter
     * @return string Return text if param not passed rules
     */
    public function validate($value, string $rule): ?string;
}
