<?php

require_once '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Application' . DIRECTORY_SEPARATOR . 'GetPosts.php';
require_once 'PHPUnit.php';

class GetPostsTest extends PHPUnit\Framework\TestCase
{
    // contains the object handle of the string class
    var $getPosts;

    // constructor of the test suite
    function ApiTest($name) {
       $this->PHPUnit_TestCase($name);
    }

    /**
     * setUp - instantiate our test object
     */
    protected function setUp() :void
    {
      parent::setUp();
      $this->getPosts = new \Application\getPosts();
    }

    /**
     * [1] - Ensure that getPostsByPage always returns the correct type.
     */
    public function testGetPostsByPageReturnsObject()
    {
      $this->assertIsObject($this->getPosts->getPostsByPage());
    }
  }
?>