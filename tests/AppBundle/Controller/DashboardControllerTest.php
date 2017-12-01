<?php

/*
 * This file is part of the Madisoft Backend Test Developer project.
 *
 * (c) Francesco Cartenì <http://www.multimediaexperiencestudio.it/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;

/**
 * Class DashboardControllerTest.
 */
class DashboardControllerTest extends WebTestCase
{
    /** @var Client */
    private $client;

    public function setUp ()
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider urlProvider
     *
     * @param $url
     */
    public function testRoutes ($url)
    {
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()
                                       ->isSuccessful());
    }

    /**
     * @dataProvider redirectUrlProvider
     *
     * @param $url
     */
    public function testRedirect ($url)
    {
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()
                                       ->isRedirect());
    }

    public function testIfZipFileIsDownloaded ()
    {
        $this->client->request('GET', '/dashboard/report/csv');

        $this->assertSame(200, $this->client->getResponse()
                                            ->getStatusCode(), 'Wrong status code');

        $this->assertSame('application/zip', $this->client->getResponse()->headers->get('Content-Type'),
                          'Wrong content type');

        $this->assertContains('studentsWithAverage.zip',
                              $this->client->getResponse()->headers->get('Content-Disposition'), 'Wrong filename');
    }

    public function testIfMailSent ()
    {
        $this->client->enableProfiler();

        $this->client->request('GET', 'dashboard/sendmail/1');

        /** @var MessageDataCollector $mailCollector */
        $mailCollector = $this->client->getProfile()
                                      ->getCollector('swiftmailer');

        // Check that an email was sent
        $this->assertSame(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();

        /** @var \Swift_Message $message */
        $message = $collectedMessages[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertContains('Avviso media voti.', $message->getSubject());
        $this->assertSame('myschool@school.com', key($message->getFrom()));
        $this->assertSame('torquato.tasso@gmail.com', key($message->getTo()));
        $this->assertContains('Ti consiglio di studiare di più', $message->getBody());
    }

    public function testStudentEditForm ()
    {
        $crawler = $this->client->request('GET', 'dashboard/edit/1');

        // Current marks.
        $this->assertSame(2, $crawler->filter('div.mark-entity')
                                     ->count());

        $form = $crawler->selectButton('saveStudent')
                        ->form();

        $values = $form->getPhpValues();

        $values['student_form']['name'] = 'Foo'; // Torquato

        // Edit existing mark.
        $values['student_form']['marks'][0]['subject'] = 1; // Italiano
        $values['student_form']['marks'][0]['score'] = '8'; // 10
        $values['student_form']['marks'][0]['notes'] = 'We are testing!';

        // Add a new mark.
        $values['student_form']['marks'][2]['subject'] = 3;
        $values['student_form']['marks'][2]['score'] = '10';
        $values['student_form']['marks'][2]['notes'] = 'Good job!';

        $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

        $this->assertTrue($this->client->getResponse()
                                       ->isRedirect());
        $crawler = $this->client->followRedirect();

        $this->assertRegexp('/Foo/', $this->client->getResponse()
                                                  ->getContent());

        $this->assertRegexp('/Good job/', $this->client->getResponse()
                                                       ->getContent());

        // Now there are 3 marks.
        $this->assertSame(3, $crawler->filter('.mark-entity')
                                     ->count());
    }

    public function testItDeletesEmptyMarksInStudentEditForm ()
    {
        $crawler = $this->client->request('GET', 'dashboard/edit/1');

        // Current marks.
        $this->assertCount(3, $crawler->filter('.mark-entity'));

        $form = $crawler->selectButton('saveStudent')
                        ->form();

        $values = $form->getPhpValues();

        // Add a new "empty" mark.
        $values['student_form']['marks'][3]['subject'] = '';
        $values['student_form']['marks'][3]['score'] = '';
        $values['student_form']['marks'][3]['notes'] = '';

        $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

        $this->assertTrue($this->client->getResponse()
                                       ->isRedirect());
        $crawler = $this->client->followRedirect();

        // Now there are also 3 marks.
        $this->assertCount(3, $crawler->filter('.mark-entity'));
    }

    /**
     * @return array
     */
    public function urlProvider ()
    {
        return [
            ['dashboard/'],
            ['dashboard/new'],
            ['dashboard/sendmail/request/1'],
            ['dashboard/summary'],
        ];
    }

    /**
     * @return array
     */
    public function redirectUrlProvider ()
    {
        return [
            ['/'],
            ['dashboard/sendmail/1'],
        ];
    }
}
