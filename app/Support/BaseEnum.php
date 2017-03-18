<?php

namespace App\Support;

use JsonSerializable;
use ReflectionClass;
use RuntimeException;

abstract class BaseEnum implements JsonSerializable
{
    protected static $values = [];

    /**
     * @var string|null
     */
    protected $name;

    /**
     * 정적 생성자
     *
     * @param string|null $name
     * @return static
     */
    public static function getInstance(string $name = '')
    {
        return new static($name);
    }

    /**
     * $name에 담긴 문자열 값(ENUM 이름)을 조회합니다.
     *
     * @return null|string
     */
    public function getName()
    {
        if (is_null($this->name)) {
            return null;
        }

        return $this->name;
    }

    /**
     * ENUM에 할당된 값을 조회합니다.
     *
     * @return mixed
     */
    public function getValue()
    {
        return constant("static::{$this->name}");
    }

    /**
     * 빈 값이 할당되어 있는지 확인합니다.
     *
     * @return bool
     */
    public function isEmpty(){
        return get_sanitized_length($this->name) == 0;
    }

    /**
     * 인자로 받은 상수 값이 초기화되어 있는지 확인합니다
     *
     * @param string $value
     * @return bool
     */
    public static function exists(string $value)
    {
        return in_array($value, static::toArray(), true);
    }

    /**
     * 초기화된 전체 상수 배열을 조회합니다.
     *
     * @return array
     */
    public static function toArray()
    {
        $class = get_called_class();

        if (! isset(static::$values[$class])) {
            $reflection = new ReflectionClass($class);
            static::$values[$class] = $reflection->getConstants();
        }

        return static::$values[$class];
    }

    /**
     * JSON 캐스팅합니다.
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->getValue();
    }

    /**
     * 문자열로 캐스팅합니다.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * BaseEnum constructor.
     * @param string|null $name
     */
    private function __construct($name = null)
    {
        if (is_null($name)) {
            $this->name = 'EMPTY';

            return;
        }

        if (! defined('static::' . $name)) {
            throw new RuntimeException(
                sprintf('정의되지 않은 상수입니다. "%s:%s"', get_called_class(), $name)
            );
        }

        $this->name = $name;
    }
}