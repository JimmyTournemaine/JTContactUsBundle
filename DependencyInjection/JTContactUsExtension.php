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
		$container->setParameter('jt_contact_us.class.user', $classes['user']);

		/* Forms */
		$forms = $config['form'];
		$container->setParameter('jt_contact_us.form.contact', $forms['contact']);
		$container->setParameter('jt_contact_us.form.subject', $forms['subject']);

		/* Anonymous */
		$container->setParameter('jt_contact_us.anonymous', $config['anonymous']);
		/* Mailer */
		$container->setParameter('jt_contact_us.mailer', $config['mailer']);

		/* Set strategy */
		$strategy = $config['strategy'];
		if($strategy == 'mail')
		{
			if($classes['subject'] == null && $receiver == null){
				throw new \LogicException('Your config is not able to send a mail. Define a subject entity or a delivery address');
			}
			$container->setParameter('jt_contact_us.delivery_address', $config['delivery_address']);
			
			$loader->load('services/mail.yml');
		/* ORM options config */
		} 
		elseif($strategy == 'orm') {
			$container->setParameter('jt_contact_us.displayed_address', $config['displayed_address']);
			$loader->load('services/orm.yml');
		}

        $loader->load('services/services.yml');
    }
}
