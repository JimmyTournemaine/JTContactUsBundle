<?php

namespace JT\ContactUsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class JTContactUsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

		/* Classes */
		$classes = $config['class'];
		$container->setParameter('jt_contact_us.class.contact', $classes['contact']);
		$container->setParameter('jt_contact_us.class.subject', $classes['subject']);

		/* Forms */
		$forms = $config['form'];
		$container->setParameter('jt_contact_us.form.contact', $forms['contact']);
		$container->setParameter('jt_contact_us.form.subject', $forms['subject']);
		$container->setParameter('jt_contact_us.form.answer', $forms['answer']);

		/* Anonymous */
		$container->setParameter('jt_contact_us.anonymous', $config['anonymous']);

		/* Set strategy */
		$strategy = $config['strategy'];

		/* Set receivers */
        if(!isset($config['delivery_addresses'])){
            throw new \LogicException('You need to define at least a delivery_address');
        }
        $container->setParameter('jt_contact_us.delivery_addresses', $config['delivery_addresses']);

        if($strategy == 'orm'){
            /* Set info showing */
            $hide = $config['hide_infos'];
            $container->setParameter('jt_contact_us.hide_infos', $hide);
            if($hide !== false){
                if(!isset($config['displayed_infos'])){
                    throw new \LogicException('You must set the displayed info for your answers.');
                }
                $container->setParameter('jt_contact_us.displayed_infos', $config['displayed_infos']);
            }
        }

        /* Load services */
        $loader->load('services/services.yml');
        $loader->load('services/'.$strategy.'.yml');
    }
}
