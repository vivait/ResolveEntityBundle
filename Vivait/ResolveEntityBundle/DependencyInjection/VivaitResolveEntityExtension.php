<?php

namespace Vivait\ResolveEntityBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class VivaitResolveEntityExtension extends Extension implements PrependExtensionInterface {
	public function prepend(ContainerBuilder $container) {
		$configs = $container->getExtensionConfig($this->getAlias());
		$config = $this->processConfiguration(new Configuration(), $configs);

		// check if entity_manager_name is set in the "acme_hello" configuration
		if ($config['resolve_target_entities']) {
			// prepend the acme_something settings with the entity_manager_name
			$config = [
				'orm' => [
					'resolve_target_entities' => $config['resolve_target_entities']
				]
			];

			$container->prependExtensionConfig('doctrine', $config);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function load(array $configs, ContainerBuilder $container) {
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);

		$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.yml');

		if ($config['resolve_target_entities']) {
			$def = $container->findDefinition('vivait_resolve_entity.entity_map_service');
			foreach ($config['resolve_target_entities'] as $name => $implementation) {
				$def->addMethodCall('add', array(
					$name, $implementation
				));
			}
		}
	}
}
