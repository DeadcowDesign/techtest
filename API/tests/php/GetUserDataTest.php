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

    // Make sure that we get an object back from our userdata
    public function test_getUserData_returns_an_object() :void
    {
      $expected = $this->getUserData->getUserData();

      $this->assertIsObject($expected);
      $this->assertObjectHasAttribute('users', $expected);
    }

    // Make sure that we get an object back from our userdata
    public function test_getUserData_returns_a_valid_user_object() :void
    {
      $_GET['username'] = 'Quyen Pellegrini';
      $expected = $this->getUserData->getUserData();

      $this->assertIsObject($expected);
      $this->assertObjectHasAttribute('username', $expected);
      $this->assertObjectHasAttribute('totalPosts', $expected);
      $this->assertObjectHasAttribute('averageCharacters', $expected);
      $this->assertObjectHasAttribute('longestPost', $expected);
      $this->assertObjectHasAttribute('postMonths', $expected);
    }

    // Check we get back an emtpy object if we send a user who doesn't exist to the
    // API
    public function test_getUserData_returns_an_empty_object_on_invalid_input() :void
    {
      $_GET['username'] = 'Testy McTestface';
      $expected = $this->getUserData->getUserData();

      $this->assertIsObject($expected);
      $this->assertEquals(new \StdClass(), $expected);
    }
}