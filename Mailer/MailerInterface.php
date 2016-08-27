<?php
namespace JT\ContactUsBundle\Mailer;

interface MailerInterface
{
    /**
     * Send the message
     */
    public function send();
}