<?php

namespace JT\ContactUsBundle\Controller;

use JT\ContactUsBundle\Model\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{

    public function showAction(Request $request)
    {
        $anonymous = $this->getParameter('jt_contact_us.anonymous');
        if($anonymous === false && $this->isGranted('IS_AUTHENTICATED_REMEMBERED') === false){
            throw $this->createAccessDeniedException();
        }

        $contactClass = $this->getParameter('jt_contact_us.class.contact');
        $formClass = $this->getParameter('jt_contact_us.form.contact');
        $contact = new $contactClass;
        $form = $this
            ->createForm($formClass, $contact)
            ->handleRequest($request)
        ;

        if ($form->isSubmitted() && $form->isValid()) {
            $managerService = $this->getParameter('jt_contact_us.manager');
            $manager = $this->get($managerService);
            $manager->send($contact);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('JTContactUsBundle:Contact:show.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
