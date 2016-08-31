<?php
namespace JT\ContactUsBundle\Controller;

use JT\ContactUsBundle\Model\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ORMContactController extends Controller
{
	public function indexAction()
	{
		$contactClass = $this->getParameter('jt_contact_us.class.contact');
		$contacts = $this->getDoctrine()->getManager()->getRepository($contactClass)->findAll();

		return $this->render('JTContactUsBundle:Contact:index.html.twig', array(
				'contacts' => $contacts,
		));
	}

	public function answerAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$contactClass = $this->getParameter('jt_contact_us.class.contact');

		if(null == $contact = $em->getRepository($contactClass)->find($id)) {
			throw $this->createNotFoundException();
		}

		$formType = $this->getParameter('jt_contact_us.form.answer');
		$form = $this->createForm($formType)
			->handleRequest($request)
		;

		if($form->isSubmitted() && $form->isValid())
		{
			$data = $form->getData();
			$this->get('jt_contact_us.manager')->answer($contact, $data['content'], $data['hide']);

			return $this->redirectToRoute('jt_contact_us_orm_contact_index');
		}

		return $this->render("JTContactUsBundle:Contact:answer.html.twig", array(
				'contact' => $contact,
				'form' => $form->createView(),
		));
	}
}

