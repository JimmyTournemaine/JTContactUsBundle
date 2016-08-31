<?php
namespace JT\ContactUsBundle\Mailer;

use JT\ContactUsBundle\Model\ContactInterface;
use JT\ContactUsBundle\Model\SubjectInterface;

class Mailer implements AnswerMailerInterface
{
    private $mailer;
	private $addresses;
	private $displayed;

	public function __construct(\Swift_Mailer $mailer, $deliveryAddresses, $displayed = null)
	{
		$this->mailer = $mailer;
		$this->addresses = $deliveryAddresses;
		$this->displayed = $displayed;
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



     /**
      * @see \JT\ContactUsBundle\Mailer\AnswerMailerInterface::answer()
      */
     public function answer(ContactInterface $contact, $answer, $hideInfos)
     {
         if ($hideInfos) {
             if (isset($this->displayed['name'])){
                 $from = array($this->displayed['email'] => $this->displayed['name']);
             } else {
                 $from = $this->displayed['email'];
             }
         } else {
             $from = ($contact->getSubject() instanceof SubjectInterface) ? $contact->getSubject()->getTo() : $this->deliveryAddresses[0];
         }

         $subject = 'Re: ' . (($contact->getSubject() instanceof SubjectInterface) ? $contact->getSubject()->getLabel() : $contact->getSubject());

         $message = \Swift_Message::newInstance()
            ->setFrom($from)
            ->setTo(array($contact->getEmail() => $contact->getName()))
            ->setSubject($subject)
            ->setBody($answer)
         ;

         $this->mailer->send($message);
     }

}
