<?php
namespace JT\ContactUsBundle\Form\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AnswerListener implements EventSubscriberInterface
{
    private $hideInfos;

    public function __construct($hideInfos)
    {
        $this->hideInfos = $hideInfos;
    }

    /**
     * @see \Symfony\Component\EventDispatcher\EventSubscriberInterface::getSubscribedEvents()
     */
    static public function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
        );
    }

    public function onPreSetData(FormEvent $event)
    {
        if($this->hideInfos === null)
        {
            $event->getForm()->add('hide', CheckboxType::class, array('label' => 'answer.labels.hide', 'data' => false));
        }
    }

    public function onPreSubmit(FormEvent $event)
    {
        $event->getForm()->add('hide', CheckboxType::class);

        if($this->hideInfos !== null)
        {
            $data = $event->getData();
            $data['hide'] = $this->hideInfos;
            $event->setData($data);
        }
    }
}