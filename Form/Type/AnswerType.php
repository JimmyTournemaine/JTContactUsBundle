<?php
namespace JT\ContactUsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use JT\ContactUsBundle\Form\Listener\AnswerListener;

/**
 * The Form Contact Type
 *
 * The ChoiceType is used for 'subject' instead of Entity because in 'mail' strategy we don't have any Contact entity, just the model.
 *
 * @author Jimmy Tournemaine <jimmy.tournemaine@yahoo.fr>
 */
class AnswerType extends AbstractType
{
    private $hide;

    public function __construct($hideInfos){
        $this->hide = $hideInfos;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, array(
                    'label' => 'answer.labels.content'
            ))
            ->addEventSubscriber(new AnswerListener($this->hide));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => null,
            'translation_domain' => 'JTContactUsBundle'
        ));
    }
}