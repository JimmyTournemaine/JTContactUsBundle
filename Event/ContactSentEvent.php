<?php
namespace JT\ContactUsBundle\Event;

class ContactSentEvent extends ContactEvent
{
	const NAME = 'jt_contact_us.contact_sent';

	private $redirectionUrl;

	public function __construct(ContactInterface $contact, $redirectionUrl)
	{
		parent::__construct($contact);
		$this->redirectionUrl = $redirectionUrl;
	}	

	public function setRedirectionUrl($url)
	{
		$this->redirectionUrl = $url;
	}

	public function getRedirectionUrl()
	{
		return $this->redirectionUrl;
	}
}


