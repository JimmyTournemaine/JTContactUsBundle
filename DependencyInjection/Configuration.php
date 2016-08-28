<?php
namespace JT\ContactUsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritdoc}
     *
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jt_contact_us');

        $rootNode
            ->children()
                ->enumNode('strategy')
					->defaultValue('mail')
					->values(array('orm','mail'))
					->isRequired()
				->end()
				->arrayNode('class')
				->addDefaultsIfNotSet()
					->children()
						->scalarNode('contact')->defaultValue('JT\ContactUsBundle\Model\Contact')->end()
						->scalarNode('subject')->defaultNull()->end()
						->scalarNode('user')->defaultNull()->end()
					->end()
				->end()
				->arrayNode('form')
				->addDefaultsIfNotSet()
					->children()
						->scalarNode('contact')->defaultValue('JT\ContactUsBundle\Form\Type\ContactType')->end()
						->scalarNode('subject')->defaultValue('JT\ContactUsBundle\Form\Type\SubjectType')->end()
					->end()
				->end()
				->scalarNode('mailer')->defaultValue('jt_contact_us.mailer')->end()
				->booleanNode('anonymous')->defaultTrue()->end()
				->scalarNode('delivery_address')
					->defaultNull()
					->info('Set this value if you use the mail startegy without subject entity.')
				->end()
				->scalarNode('displayed_address')
					->defaultNull()
					->info('Set this value if you use the orm startegy and does\'t want to show your real email.')
				->end()
				
            ->end()
        ;

        return $treeBuilder;
    }
}
