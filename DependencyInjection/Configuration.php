<?php

namespace Vivait\ResolveEntityBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface {
	/**
	 * {@inheritDoc}
	 */
	public function getConfigTreeBuilder() {
		$treeBuilder = new TreeBuilder();
		$rootNode    = $treeBuilder->root('vivait_resolve_entity');

		$rootNode
			->fixXmlConfig('resolve_target_entity', 'resolve_target_entities')
			->children()
					->arrayNode('resolve_target_entities')
						->useAttributeAsKey('interface')
						->prototype('scalar')
						->cannotBeEmpty()
					->end()
			->end();

		return $treeBuilder;
	}
}
