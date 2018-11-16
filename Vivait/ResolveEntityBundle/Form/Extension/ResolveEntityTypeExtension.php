<?php

namespace Vivait\ResolveEntityBundle\Form\Extension;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vivait\ResolveEntityBundle\Service\EntityMapService;

class ResolveEntityTypeExtension extends AbstractTypeExtension {
	/**
	 * @var ManagerRegistry
	 */
	protected $registry;

	/**
	 * @var EntityMapService
	 */
	protected $entity_map;

	public function __construct($registry, $entity_map) {
		$this->registry   = $registry;
		$this->entity_map = $entity_map;
	}

	public function setDefaultOptions(OptionsResolver $resolver) {
		$entity_map = $this->entity_map;
		$registry   = $this->registry;

		$classNormalizer = function (Options $options, $class) use ($entity_map, $registry) {
			// Check for namespace alias
			if (strpos($class, ':') !== false) {
				list($namespaceAlias, $simpleClassName) = explode(':', $class);
				$class = $registry->getAliasNamespace($namespaceAlias) . '\\' . $simpleClassName;
			}

			return $entity_map->get($class, $class);
		};

		$resolver->setNormalizer('class', $classNormalizer);
	}

	/**
	 * Returns the name of the type being extended.
	 *
	 * @return string The name of the type being extended
	 */
	public function getExtendedType() {
		return EntityType::class;
	}
}
