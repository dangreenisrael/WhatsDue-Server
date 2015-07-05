<?php

namespace Whatsdue\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeacherControllerTest extends WebTestCase
{
    private $client;
    public function __construct(){
        $this->client = static::createClient();
        $this->client->followRedirects();
    }

    public function testCreateStuff()
    {


        /*
         * Add an Assignment
         */
        $this->client->request(
            'POST',
            '/api/teacher/courses',
            array(),
            array(),
            array(
                'key'       => '633',
                'secret'    => 'testpass',
                'CONTENT_TYPE' => 'application/json'
            ),
            '{"course":
                 {
                    "course_name":"Demo Course",
                    "instructor_name":"Dan Green",
                    "archived":false
                 }
            }'
        );


        $this->assertTrue($this->client->getResponse()->isSuccessful());


        exit;

        /*
         * Add an Assignment
         */
        $this->client->request(
            'POST',
            '/api/teacher/assignments',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{
                "assignment": {
                    "admin_id": null,
                    "archived": false,
                    "assignment_name": "Homework",
                    "course_id": 400,
                    "description": "Test Description,",
                    "due_date": "2015-10-29 09:00",
                    "time_of_day": "Morning",
                    "time_visible": false
                }
            }'
        );
        var_dump($this->client->getResponse()->getStatusCode());
        $this->assertEquals(
            200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
            $this->client->getResponse()->getStatusCode()
        );
    }
}