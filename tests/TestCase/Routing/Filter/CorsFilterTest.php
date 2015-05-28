<?php
/**
 * CakePHP(tm) Tests <http://book.cakephp.org/view/1196/Testing>
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The Open Group Test Suite License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://book.cakephp.org/view/1196/Testing CakePHP(tm) Tests
 * @since         2.2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\Routing\Filter;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cors\Routing\Filter\CorsFilter;

/**
 * Cors filter test case.
 */
class CorsFilterTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->request = new Request();
        $this->request->env('HTTP_ORIGIN', 'test.org');
        $this->request->addParams(['controller' => 'Fun', 'action' => 'times']);
        $this->response = $this->getMock('Cake\Network\Response', ['_sendHeader']);
        $this->event = new Event('Dispatcher.beforeDispatch', $this, ['request' => $this->request, 'response' => $this->response]);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }


    public function testNoController()
    {
        $filter = new CorsFilter();

        $filter->beforeDispatch($this->event);

        $headers = $this->response->header();
        $this->assertArrayNotHasKey('Access-Control-Allow-Origin', $headers);
    }

    public function testControllerOnly()
    {
        $filter = new CorsFilter(['routes' => ['Fun']]);

        $filter->beforeDispatch($this->event);

        $headers = $this->response->header();
        $this->assertEquals('*', $headers['Access-Control-Allow-Origin']);
    }

    public function testSingleAction()
    {
        $filter = new CorsFilter(['routes' => ['Fun' => 'times']]);

        $filter->beforeDispatch($this->event);

        $headers = $this->response->header();
        $this->assertEquals('*', $headers['Access-Control-Allow-Origin']);
    }

    public function testMultipleAction()
    {
        $filter = new CorsFilter(['routes' => [
            'Fun' => [
                'times',
                'place']]]);

        $filter->beforeDispatch($this->event);

        $headers = $this->response->header();
        $this->assertEquals('*', $headers['Access-Control-Allow-Origin']);
    }

    public function testScopedOrigin()
    {
        $filter = new CorsFilter(['routes' => [
            'Fun' => [
                'times' => [
                    'origin' => 'test.org']]]]);

        $filter->beforeDispatch($this->event);

        $headers = $this->response->header();
        $this->assertEquals('test.org', $headers['Access-Control-Allow-Origin']);
        $this->assertArrayNotHasKey('Access-Control-Allow-Methods', $headers);
    }

    public function testScopedMethods()
    {
        $filter = new CorsFilter(['routes' => [
            'Fun' => [
                'times' => [
                    'methods' => 'PUT,DELETE']]]]);

        $filter->beforeDispatch($this->event);

        $headers = $this->response->header();
        $this->assertEquals('*', $headers['Access-Control-Allow-Origin']);
        $this->assertEquals('PUT,DELETE', $headers['Access-Control-Allow-Methods']);
    }

    public function testScopedOriginAndMethods()
    {
        $filter = new CorsFilter(['routes' => [
            'Fun' => [
                'times' => [
                    'origin' => 'test.org',
                    'methods' => 'PUT,DELETE']]]]);

        $filter->beforeDispatch($this->event);

        $headers = $this->response->header();
        $this->assertEquals('test.org', $headers['Access-Control-Allow-Origin']);
        $this->assertEquals('PUT,DELETE', $headers['Access-Control-Allow-Methods']);
    }
}