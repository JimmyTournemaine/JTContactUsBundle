<?php
namespace JT\ContactUsBundle\Mailer;

class Mailer implements MailerInterface
{
    private $swiftMailer;

    public function __construct()
    {

    }

    /**
     * @see \JT\ContactUsBundle\Mailer\MailerInterface::send()
     */
    public function send()
    {
        // TODO: Auto-generated method stub
    }
}