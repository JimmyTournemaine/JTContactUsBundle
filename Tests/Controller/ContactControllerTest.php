<?php

namespace JT\ContactUsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
		$form = $crawler->selectButton('submit')->form();
		$form['name'] = 'Jimmy';
		$form['email'] = 'jimmytournemaine@yahoo.fr';
		$form['subject'] = 'A great bundle';
		$form['content'] = 'Your bundle is so easy to use. I love it !';

		$crawler = $client->submit($form);
    }

}
