<?php
namespace JT\ContactUsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

abstract class ContactEvent extends Event
{
	protected $contact;

	public function __construct(ContactInterface $contact)
	{
		$this->contact = $contact;
	}

	public function getContact()
	{
		return $this->contact;
	}
}


