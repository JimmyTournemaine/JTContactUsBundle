<?php
namespace JT\ContactUsBundle\Form\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Doctrine\Common\Persistence\ObjectManager;

class ContactListener implements EventSubscriberInterface
{
    private $om;
    private $className;

    public function __construct(ObjectManager $manager, $subjectClass)
    {
        $this->om = $manager;
        $this->className = $subjectClass;
    }

    /**
     * @see \Symfony\Component\EventDispatcher\EventSubscriberInterface::getSubscribedEvents()
     */
    static public function getSubscribedEvents()
    {
        return array(
            FormEvents::POST_SUBMIT => 'onPostSubmit',
        );
    }

    public function onPostSubmit(FormEvent $event)
    {
        $contact = $event->getData();
        $strSubject = $contact->getSubject();

        // Test if it is a free subject (string) or an ID (integer)
        if(!is_numeric($strSubject)){
            return;
        }

        $subject = $this->om->getRepository($this->className)->find($strSubject);
        if($subject === null){
            throw new \LogicException("The subject send by the contact form does not exist !");
        }

        $event->setData($contact->setSubject($subject));
    }
}