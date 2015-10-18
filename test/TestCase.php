<?php

class TestCase extends PHPUnit_Framework_TestCase
{
  protected function callProtectedMethod($className, $methodName, $params)
  {
    $class  = new ReflectionClass($className);
    $method = $class->getMethod($methodName);
    $method->setAccessible(true);

    $obj = new $className($params);
    return $method->invokeArgs($obj, $params);
  }
}