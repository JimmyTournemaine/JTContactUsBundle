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

class SubjectType extends AbstractType
{
    private $subjectClass;
    private $userClass;

    public function __construct($subjectClass, $userClass){
        $this->subjectClass = $subjectClass;
        $this->userClass = $userClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, array(
                'label' => 'subject.labels.label',
		        ))
		;

		if($userClass !== null) {
			$builder->add('to', EntityType::class, array(
				'class' => $this->userClass,
				'property' => 'email',
		    	'label' => 'subject.labels.to',
		    ));
		} else {
			$builder->add('to', TextType::class, array(
		    	'label' => 'subject.labels.to',
		    ));
		}
		;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => $this->subjectClass,
            'translation_domain' => 'JTContactUsBundle'
        ));
    }
}
