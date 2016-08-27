<?php
namespace JT\ContactUsBundle\Manager;

use JT\ContactUsBundle\Model\ContactInterface;

interface ManagerInterface
{
    public function send(ContactInterface $contact);
}