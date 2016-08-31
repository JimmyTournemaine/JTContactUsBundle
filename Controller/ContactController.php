<?php
namespace JT\ContactUsBundle\Controller;

use JT\ContactUsBundle\Model\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JT\ContactUsBundle\Event\ContactSentEvent;

/**
 * Controller to contact form
 *
 * @author Jimmy Tournemaine <jimmy.tournemaine@yahoo.fr>
 */
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
            $this->get('jt_contact_us.manager')->send($contact);
            $this->addFlash('notice', $this->get('translator')->trans('contact.flash.sent', [], 'JTContactUsBundle'));
			$event = new ContactSentEvent($contact, $this->redirectToRoute('jt_contact_us_contact_form'));
			$dispatcher = $this->get('event_dispatcher');
			$dispatcher->dispatch(ContactSentEvent::NAME, $event);

            return $event->getResponse();
        }

        return $this->render('JTContactUsBundle:Contact:form.html.twig', array(
            'form' => $form->createView()
        ));
    }

}

