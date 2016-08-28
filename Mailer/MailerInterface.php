<?php
namespace JT\ContactUsBundle\Mailer;

interface MailerInterface
{
	public function setFrom(array $from);

	public function setContent($content);

    /**
     * Send the message
     */
    public function send();
}
