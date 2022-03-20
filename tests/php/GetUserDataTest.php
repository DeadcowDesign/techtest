<?php

require_once '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Application' . DIRECTORY_SEPARATOR . 'GetUserData.php';
require_once 'PHPUnit.php';

class GetUserDataTest extends PHPUnit\Framework\TestCase
{
    // contains the object handle of the string class
    var $getUserData;

    // Initialize our test suite
    function ApiTest($name) {
       $this->PHPUnit_TestCase($name);
    }

    /**
     * setUp - instantiate our test object
     */
    protected function setUp() :void
    {
      parent::setUp();
      $this->getUserData = new \Application\GetUserData();
    }

    // Reflection - allow access to any protected methods that we might want to test
    protected static function getMethod($name) 
    {
      $class = new ReflectionClass('\Application\GetUserData');
      $method = $class->getMethod($name);
      $method->setAccessible(true);
      return $method;
    }

    public function test_getUserData_can_pull_a_complete_list_of_posts_by_author_name() :void
    {
      
    }
}