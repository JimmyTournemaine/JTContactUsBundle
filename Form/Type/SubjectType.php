<?php
namespace JT\ContactUsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectType extends AbstractType
{
    private $subjectClass;
    private $deliveryAddresses;

    public function __construct($subjectClass, $deliveryAddresses){
        $this->subjectClass = $subjectClass;
        $this->deliveryAddresses = $deliveryAddresses;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        dump($this->deliveryAddresses);
        $builder
            ->add('label', TextType::class, array(
                'label' => 'subject.labels.label',
		    ))
		    ->add('to', ChoiceType::class, array(
                'label' => 'subject.labels.to',
                'choices' => $this->addressesToChoices(),
            ))
		;
    }

    private function addressesToChoices()
    {
        $choices = array();
        foreach($this->deliveryAddresses as $addr){
            $choices[$addr] = $addr;
        }
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => $this->subjectClass,
            'translation_domain' => 'JTContactUsBundle'
        ));
    }
}
