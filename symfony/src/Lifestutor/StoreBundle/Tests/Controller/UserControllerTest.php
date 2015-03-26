<?php

namespace Lifestutor\StoreBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Lifestutor\StoreBundle\DataFixtures\MongoDB\LoadUserData;

class UserControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->auth = array(
            'PHP_AUTH_USER' => 'testuser',
            'PHP_AUTH_PW'   => 'testpass',
        );

        $this->client = static::createClient(array(), $this->auth);
    }

    public function testJsonGetUserAction()
    {
        $fixtures = array('Lifestutor\StoreBundle\DataFixtures\MongoDB\LoadUserData');
        $this->loadFixtures($fixtures, null, 'doctrine_mongodb');
        $users = LoadUserData::$users;
        $user = array_pop($users);

        $route =  $this->getUrl('api_1_get_user', array('id' => $user->getId(), '_format' => 'json'));

        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, 200);

        $content = $response->getContent();
        $decoded = json_decode($content, true);

        $this->assertTrue(isset($decoded['username']));
    }

    public function testJsonPostUserAction()
    {
        $this->client = static::createClient();
        $this->client->request(
            'POST', 
            '/api/v1/users.json',  
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"username":"jebhie@yahoo.com","password":"testpass","firstname":"Test User"}'
        );
        $this->assertJsonResponse($this->client->getResponse(), 201, false);
    }

    public function testJsonPostPageActionShouldReturn400WithBadParameters()
    {
        $this->client = static::createClient();
        $this->client->request(
            'POST',
            '/api/v1/users.json',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"ninja":"turtles"}'
        );

        $this->assertJsonResponse($this->client->getResponse(), 400, false);
    }

    protected function assertJsonResponse(
        $response, 
        $statusCode = 200, 
        $checkValidJson =  true, 
        $contentType = 'application/json'
    )
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', $contentType),
            $response->headers
        );

        if ($checkValidJson) {
            $decode = json_decode($response->getContent());
            $this->assertTrue(($decode != null && $decode != false),
                'is response valid json: [' . $response->getContent() . ']'
            );
        }
    }
}