<?php
namespace JT\ContactUsBundle\Event;

use JT\ContactUsBundle\Model\ContactInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Allow you to set the response after contact is sent/persist
 *
 * @author Jimmy Tournemaine <jimmy.tournemaine@yahoo.fr>
 */
class ContactSentEvent extends ContactEvent
{
	const NAME = 'jt_contact_us.contact_sent';

	private $response;

	public function __construct(ContactInterface $contact, Response $response)
	{
		parent::__construct($contact);
		$this->response = $response;
	}

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

}


