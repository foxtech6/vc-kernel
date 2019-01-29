<?php

namespace Foxtech\Kernel;

use Foxtech\Kernel\Exceptions\NotFoundException;
use InvalidArgumentException;
use Foxtech\Kernel\Validators\{ValidatorInterface, NumberValidator, RequiredValidator, MaxValidator, MinValidator};

/**
 * Class AbstractRequest
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 27.01.2019
 */
abstract class AbstractRequest
{
    /**
     * All params from client
     *
     * @var array
     */
    protected $params = [];

    /**
     * Associate array, key - param name and value
     *
     * @var array
     */
    protected $paramsValue = [];

    /**
     * Error messages
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Validators for params
     *
     * @var array
     */
    protected $validators = [
        'number' => NumberValidator::class,
        'max' => MaxValidator::class,
        'min' => MinValidator::class,
        'required' => RequiredValidator::class
    ];

    /**
     * AbstractRequestHandler constructor
     *
     * @param array $params All params from client
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Get params as class property
     *
     * @param string $name  Param name
     *
     * @return mixed Return param value
     */
    public function __get(string $name)
    {
        if (!isset($this->paramsValue[$name])) {
            throw new InvalidArgumentException('Params ' . $name . ' not found');
        }

        return $this->paramsValue[$name];
    }

    /**
     * Handler for params
     *
     * @throws NotFoundException
     */
    public function handle(): void
    {
        foreach ($this->params as $name => $value) {
            if (isset($this->rules()[$name])) {
                $this->checkParams($name, $value);
            }

            $this->paramsValue[$name] = $value;
        }
    }

    /**
     * Getter for error
     *
     * @return array Return errors
     */
    public function getErrors(): array
    {
        return $this->messages;
    }

    /**
     * List rules for params
     *
     * @return array Rules for params
     */
    abstract protected function rules(): array;

    /**
     * Validate params by rules
     *
     * @param string $name  Parameter name
     * @param mixed  $value Parameter value
     *
     * @throws NotFoundException
     */
    private function checkParams(string $name, $value): void
    {
        foreach (explode('|', $this->rules()[$name]) as $rule) {
            $ruleName = $rule;

            if (false !== ($pos = strpos($rule, ':'))) {
                $ruleName = substr($rule, 0, $pos);
            }

            if (!isset($this->validators[$ruleName])) {
                throw new NotFoundException('Validator not found');
            }

            /* @var $validator ValidatorInterface */
            $validator = new $this->validators[$ruleName]();

            if ($message = $validator->validate($value, $rule)) {
                $this->messages[] = $message;
            }
        }
    }
}
