<?php
namespace JT\ContactUsBundle\Mailer;

use JT\ContactUsBundle\Model\ContactInterface;

interface MailerInterface
{
	/**
     * Send the message
     */
    public function send(ContactInterface $contact);
}
