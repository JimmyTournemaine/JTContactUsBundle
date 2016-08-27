<?php
namespace JT\ContactUsBundle\Manager;

use JT\ContactUsBundle\Model\ContactInterface;

class MailManager implements ManagerInterface
{
    private $mailer;

    /**
     * @see \JT\ContactUsBundle\Manager\ManagerInterface::send()
     */
    public function send(ContactInterface $contact)
    {
        // TODO: Auto-generated method stub
    }
}