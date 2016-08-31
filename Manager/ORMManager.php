<?php
namespace JT\ContactUsBundle\Manager;

use JT\ContactUsBundle\Model\ContactInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JT\ContactUsBundle\Mailer\AnswerMailerInterface;

class ORMManager implements ManagerInterface
{
	private $om;
	private $mailer;

	public function __construct(ObjectManager $manager, AnswerMailerInterface $mailer)
	{
		$this->om = $manager;
		$this->mailer = $mailer;
	}

	/**
	 * @see \JT\ContactUsBundle\Manager\ManagerInterface::send()
	 */
	public function send(ContactInterface $contact)
	{
		$this->om->persist($contact);
		$this->om->flush();
	}

	public function answer(ContactInterface $contact, $answer, $hideInfos)
	{
        $this->mailer->answer($contact, $answer, $hideInfos);
        $this->om->remove($contact);
        //$this->om->flush();
	}
}
