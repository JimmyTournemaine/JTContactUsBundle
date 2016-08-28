<?php
namespace JT\ContactUsBundle\Manager;

use JT\ContactUsBundle\Model\ContactInterface;

class ORMManager implements ManagerInterface
{
	private $em;
	
	public function __construct(EntityManager $manager)
	{
		$this->em = $manager;
	}

	public function send(ContactInterface $contact)
	{
		$this->em->persist($contact);
		$this->em->flush();
	}
}
