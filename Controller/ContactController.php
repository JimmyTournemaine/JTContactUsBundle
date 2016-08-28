<?php
namespace JT\ContactUsBundle\Controller;

use JT\ContactUsBundle\Model\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{

    public function formAction(Request $request)
    {
		/* Check authentication if anonymous is set to true */
        $anonymous = $this->getParameter('jt_contact_us.anonymous');
        if($anonymous === false && $this->isGranted('IS_AUTHENTICATED_REMEMBERED') === false){
            throw $this->createAccessDeniedException();
        }

		/* Create entity and form */
        $contactClass = $this->getParameter('jt_contact_us.class.contact');
        $formClass = $this->getParameter('jt_contact_us.form.contact');
        $contact = new $contactClass;
        $form = $this
            ->createForm($formClass, $contact)
            ->handleRequest($request)
        ;

		/* Form validation */
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->get('jt_contact_us.manager')->send($contact);
			$event = new ContactSentEvent($contact, $this->generateUrl('jt_contact_us_form'));
			$dispatcher = $this->get('event_dispatcher');
			$dispatcher->dispatch(ContactSentEvent::NAME, $event);

            return $this->redirectToRoute($event->getRedirectionUrl());
        }

        return $this->render('JTContactUsBundle:Contact:form.html.twig', array(
            'form' => $form->createView()
        ));
    }

}

