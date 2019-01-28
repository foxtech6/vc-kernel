<?php

namespace Foxtech\Kernel;

use Kernel\Exceptions\NotFoundException;
use Kernel\Validators\{ValidatorInterface, IntValidator, MaxValidator, MinValidator};
use InvalidArgumentException;
use LogicException;

/**
 * Class AbstractRequestHandler
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 27.01.2019
 */
abstract class AbstractRequestHandler
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
     * Validators for params
     *
     * @var array
     */
    private $validators = [
        'int' => IntValidator::class,
        'max' => MaxValidator::class,
        'min' => MinValidator::class,
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
    public function handle()
    {
        foreach ($this->params as $name => $value) {
            if (isset($this->rules()[$name])) {
                $this->checkParams($name, $value);
            }

            $this->paramsValue[$name] = $value;
        }
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
        $messages = [];

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
                $messages[] = $message;
            }
        }

        if (count($messages) > 0) {
            throw new LogicException(implode(', ', $messages));
        }
    }
}
