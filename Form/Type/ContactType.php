<?php
namespace JT\ContactUsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class ContactType extends AbstractType
{
    private $contactClass;
    private $subjectClass;

    public function __construct($contactClass, $subjectClass){
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
                'label' => 'contact.labels.name',
            ))
        ;

        if(null === $this->subjectClass) {
            $builder->add('subject', TextType::class, array(
                    'label' => 'contact.labels.subject',
            ));
        } else {
            $builder->add('subject', EntityType::class, array(
                'label' => 'contact.labels.subject',
                'class' => $this->subjectClass,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('s')->orderBy('s.label');
                },
                'choice_label' => 'label',
            ));
        }

        $builder
            ->add('content', TextareaType::class, array(
                'label' => 'contact.labels.content',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => $this->contactClass,
            'translation_domain' => 'JTContactUsBundle'
        ));
    }
}