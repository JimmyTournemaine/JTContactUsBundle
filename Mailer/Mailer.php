<?php
namespace JT\ContactUsBundle\Mailer;

class Mailer implements MailerInterface
{
    private $mailer;
	private $message;

    public function __construct(\Swift_Mailer $mailer)
    {
		$this->mailer = $mailer;
		$this->message = \Swift_Message::getInstance();
    }

	public function setFrom(array $from)
	{
		$this->message->setFrom($from);
	}

	public function setContent($content)
	{
		$this->message->setBody($content);
	}

    /**
     * @see \JT\ContactUsBundle\Mailer\MailerInterface::send()
     */
    public function send(ContactInterface $contact)
    {
		/* Set the Subject */
		if($contact->getSubject() instanceof SubjectInterface)
		{
			$this->message->setSubject($contact->getSubject()->getLabel());
		} else {
			$this->message->setSubject($contact->getSubject());
		}

		/* TODO */
		$this->message->setTo(array($contact->getName() => $contact->getEmail());
		$this->message->setBody($contact->setContent);
        $this->mailer->send($this->message);
    }
}
