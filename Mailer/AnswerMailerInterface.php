<?php
namespace JT\ContactUsBundle\Mailer;

use JT\ContactUsBundle\Model\ContactInterface;

interface AnswerMailerInterface extends MailerInterface
{
    public function answer(ContactInterface $contact, $answer, $hideInfos);
}