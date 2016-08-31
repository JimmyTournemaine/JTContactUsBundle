<?php
namespace JT\ContactUsBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use JT\ContactUsBundle\Form\Listener\ContactListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The Form Contact Type
 *
 * The ChoiceType is used for 'subject' instead of Entity because in 'mail' strategy we don't have any Contact entity, just the model.
 *
 * @author Jimmy Tournemaine <jimmy.tournemaine@yahoo.fr>
 */
class ContactType extends AbstractType
{
    private $manager;
    private $contactClass;
    private $subjectClass;

    public function __construct(ObjectManager $manager, $contactClass, $subjectClass)
    {
        $this->manager = $manager;
        $this->contactClass = $contactClass;
        $this->subjectClass = $subjectClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'contact.labels.name',
            ))
            ->add('email', EmailType::class, array(
                'label' => 'contact.labels.email',
            ))
        ;

        if(null === $this->subjectClass) {
            $builder->add('subject', TextType::class, array(
                    'label' => 'contact.labels.subject',
            ));
        } else {
            $builder->add('subject', ChoiceType::class, array(
                    'label' => 'contact.labels.subject',
                    'choices' => $this->getSubjects(),
            ))->addEventSubscriber(new ContactListener($this->manager, $this->subjectClass));
        }

        $builder
            ->add('content', TextareaType::class, array(
                'label' => 'contact.labels.content',
            ))
        ;
    }

    private function getSubjects()
    {
        $choices = array();
        foreach($this->manager->getRepository($this->subjectClass)->findAll() as $subject)
        {
            $choices[$subject->getLabel()] = $subject->getId();
        }
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => $this->contactClass,
            'translation_domain' => 'JTContactUsBundle'
        ));
    }
}