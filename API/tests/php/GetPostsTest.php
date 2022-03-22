<?php declare(strict_types=1);

require_once '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Application' . DIRECTORY_SEPARATOR . 'GetPostsByPage.php';
require_once 'PHPUnit.php';

class GetPostsTest extends PHPUnit\Framework\TestCase
{
    // contains the object handle of the string class
    var $getPosts;

    // constructor of the test suite
    function ApiTest($name) :void{
       $this->PHPUnit_TestCase($name);
    }

    /**
     * setUp - instantiate our test object
     */
    protected function setUp() :void
    {
      parent::setUp();
      $this->getPosts = new \Application\GetPostsByPage();
    }

    // Reflection - allow access to any protected methods that we might want to test
    protected static function getMethod($name) {
      $class = new ReflectionClass('\Application\GetPostsByPage');
      $method = $class->getMethod($name);
      $method->setAccessible(true);
      return $method;
    }

    /**
     * testDoCurlReturnsObjectByDefault
     * Ensure that the runCurl function returns an empty object if no valid
     * parameters are passed to it.
     * @return void
     */
    public function test_getPostsByPage_curl_returns_empty_object_by_default() :void {
      $method = self::getMethod('runCurl');
      $actual = $method->invokeArgs($this->getPosts, array(array(), false, 'register'));
      $this->assertIsObject( $actual );
    }

    /**
     * testGetTokenReturnsAValidToken
     * We can't exactly ensure that a token is valid because we don't
     * necessarily know the format, but we can ensure we get a non-empty
     * string from a token fetch attempt.
     *
     * @return void
     */
    public function test_getPostsByPage_can_retrieve_a_valid_token() :void {

      $method = self::getMethod('getSlToken');
      $actual = $method->invokeArgs($this->getPosts, array());

      $this->assertIsString($actual);
      $this->assertNotEmpty($actual);

    }

    /**
     * Make sure we get an object back from getPostsByPage and not something weird
     * or an error.
     *
     * @return void
     */
    public function test_getPostsByPage_returns_valid_object() :void {
      $actual = $this->getPosts->getPostsByPage();
      $this->assertisObject($actual);
      
    }
    /**
     * Make sure that our paginated results are coming back as expected, that we're getting
     * page (n) when we ask for it
     *
     * @return void
     */
    public function test_getPostsByPage_returns_paginated_results() {
      $_GET['page'] = 2;
      $actual = $this->getPosts->getPostsByPage();
      $this->assertEquals(2, $actual->page);
      $_GET['page'] = 3;
      $actual = $this->getPosts->getPostsByPage();
      $this->assertEquals(3, $actual->page);
    }

    /**
     * Test that we get the expected number of results back from the API (100 posts)
     * no matter what we throw at it.
     *
     * @return void
     */
    public function test_getPostsByPage_returns_correct_number_of_posts() {
      $actual = $this->getPosts->getPostsByPage();
      $this->assertCount(100, $actual->posts);

      $_GET['page'] = 1;
      $actual = $this->getPosts->getPostsByPage();
      $this->assertCount(100, $actual->posts);

      $_GET['page'] = 'foobar';
      $actual = $this->getPosts->getPostsByPage();
      $this->assertCount(100, $actual->posts);
    }

    /**
     * Test that we get back page one if we're sending a GET request with a number too high.
     * We could, alternatively, have the system return an error, but this is easier and covers
     * more edge cases.
     *
     * @return void
     */
    public function test_getPostsByPage_returns_first_page_if_page_number_overflows() {
      $_GET['page'] = 11;
      $actual = $this->getPosts->getPostsByPage();
      $this->assertEquals(1, $actual->page);
    }
    
    /**
     * As above, except we're testing what happens if we do something wacky
     * with the get request, like strings or strings with numbers, or emoji.
     *
     * @return void
     */
    public function test_getPostsByPage_returns_first_page_if_GET_is_malformed() {
      $_GET['page'] = '😀';
      $actual = $this->getPosts->getPostsByPage();
      $this->assertEquals($actual->page, 1);
      $_GET['page'] = 'foobar';
      $actual = $this->getPosts->getPostsByPage();
      $this->assertEquals($actual->page, 1);
      $_GET['page'] = 'Hello this is a completely invalid input and lets put some numbers in 123 and 4 & 7';
      $actual = $this->getPosts->getPostsByPage();
      $this->assertEquals($actual->page, 1);
    }
  }
?>