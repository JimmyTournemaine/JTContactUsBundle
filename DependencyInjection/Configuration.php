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
					->end()
				->end()
				->arrayNode('form')
				->addDefaultsIfNotSet()
					->children()
						->scalarNode('contact')->defaultValue('JT\ContactUsBundle\Form\Type\ContactType')->end()
						->scalarNode('subject')->defaultValue('JT\ContactUsBundle\Form\Type\SubjectType')->end()
						->scalarNode('answer')->defaultValue('JT\ContactUsBundle\Form\Type\AnswerType')->end()
					->end()
				->end()
				->booleanNode('anonymous')->defaultTrue()->end()
				->arrayNode('delivery_addresses')
				    ->info('The first address set will be the default one.')
					->prototype('scalar')->end()
				->end()
				->booleanNode('hide_infos')
				    ->defaultNull()
				    ->info('true: hide infos, use displayed_infos as substitute ; false: show infos ; null: let the choice during the answer writing')
				->end()
				->arrayNode('displayed_infos')
				    ->children()
				        ->scalarNode('name')->end()
				        ->scalarNode('email')->isRequired()->example('noreply@yourdomain.com')->end()
				    ->end()
				->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
