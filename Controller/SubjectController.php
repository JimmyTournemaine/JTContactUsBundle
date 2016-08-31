<?php
namespace JT\ContactUsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SubjectController extends Controller
{
	public function indexAction()
	{
		$subjectClass = $this->getParameter('jt_contact_us.class.subject');
		$subjects = $this->getDoctrine()->getManager()->getRepository($subjectClass)->findAll();

		return $this->render('JTContactUsBundle:Subject:index.html.twig', array(
				'subjects' => $subjects,
		));
	}

    public function newAction(Request $request)
	{
		$subjectClass = $this->getParameter('jt_contact_us.class.subject');
		$formType = $this->getParameter('jt_contact_us.form.subject');
		$subject = new $subjectClass;

		$form = $this->createForm($formType, $subject)->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($subject);
			$em->flush();

			return $this->redirectToRoute('jt_contact_us_subject_index');
		}

		return $this->render('JTContactUsBundle:Subject:new.html.twig', array(
				'form' => $form->createView(),
		));
	}

	public function editAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$subjectClass = $this->getParameter('jt_contact_us.class.subject');
		$formType = $this->getParameter('jt_contact_us.form.subject');

		if(null == $subject = $em->getRepository($subjectClass)->find($id)) {
			throw $this->createNotFoundException();
		}

		$form = $this->createForm($formType, $subject)->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$em->persist($subject);
			$em->flush();
		}

		return $this->render('JTContactUsBundle:Subject:edit.html.twig', array(
				'form' => $form->createView(),
		));
	}

	public function deleteAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$subjectClass = $this->getParameter('jt_contact_us.class.subject');

		if(null == $subject = $em->getRepository($subjectClass)->find($id)) {
			throw $this->createNotFoundException();
		}

		$form = $this->createFormBuilder()->getForm();
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$em->remove($subject);
			$em->flush();

			return $this->redirectToRoute('jt_contact_us_subject_index');
		}

		return $this->render('JTContactUsBundle:Subject:delete.html.twig', array(
				'form' => $form->createView(),
				'subject' => $subject,
		));
	}
}
