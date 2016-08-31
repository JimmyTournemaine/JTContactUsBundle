<?php
namespace JT\ContactUsBundle\Manager;

use JT\ContactUsBundle\Model\ContactInterface;
use JT\ContactUsBundle\Model\SubjectInterface;
use JT\ContactUsBundle\Mailer\MailerInterface;

class MailManager implements ManagerInterface
{
    private $mailer;
	private $addresses;

	public function __construct(MailerInterface $mailer, $deliveryAddresses)
	{
		$this->mailer = $mailer;
		$this->addresses = $deliveryAddresses;
	}

    /**
     * @see \JT\ContactUsBundle\Manager\ManagerInterface::send()
     */
    public function send(ContactInterface $contact)
    {
        /* Common part */
        $message = \Swift_Message::newInstance()
			->setFrom(array($contact->getEmail() => $contact->getName()))
			->setBody($contact->getContent())
		;

		/* Set subject */
		$subject = $contact->getSubject();
		if($subject instanceof SubjectInterface){
			$message->setSubject($subject->getLabel());
		} else {
			$message->setSubject($subject);
		}

		/* Set receiver */
		if($subject instanceof SubjectInterface){
		    $message->setTo($subject->getTo());
		} else {
		    $message->setTo($this->deliveryAddresses[0]);
		}

		$this->mailer->send($message);
    }
}
