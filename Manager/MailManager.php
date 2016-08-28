<?php
namespace JT\ContactUsBundle\Manager;

use JT\ContactUsBundle\Model\ContactInterface;

class MailManager implements ManagerInterface
{
    private $mailer;
	private $addr;

	public function __construct(\Swift_Mailer $mailer, $deliveryAddress)
	{
		$this->mailer = $mailer;
		$this->addr = $deliveryAddress;
	}

    /**
     * @see \JT\ContactUsBundle\Manager\ManagerInterface::send()
     */
    public function send(ContactInterface $contact)
    {
        $message = \Swift_Message::newInstance()
			->setFrom(array($contact->getName() => $contact->getEmail())
			->setTo($addr)
			->setBody($contact->getContent(), 'text/plain')
		;

		$subject = $contact->getSubject();
		if($subject instanceof SubjectInterface){
			$message->setSubject($subject->getLabel());
		} else {
			$message->setSubject($subject);
		}

		$this->mailer->send($message);
    }
}
