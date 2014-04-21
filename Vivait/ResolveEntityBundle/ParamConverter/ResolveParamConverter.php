<?php

namespace Vivait\ResolveEntityBundle\ParamConverter;

use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Vivait\ResolveEntityBundle\Service\EntityMapService;

class ResolveParamConverter extends DoctrineParamConverter {
	/**
	 * @var EntityMapService
	 */
	protected $entity_map;

	public function __construct(ManagerRegistry $registry = null, EntityMapService $entity_map = null) {
		parent::__construct($registry);

		$this->entity_map = $entity_map;
	}

	public function resolveClass($class) {
		if ($class === null) {
			return $class;
		}

		// Check for namespace alias
		if (strpos($class, ':') !== false) {
			list($namespaceAlias, $simpleClassName) = explode(':', $class);
			$class = $this->registry->getAliasNamespace($namespaceAlias) . '\\' . $simpleClassName;
		}

		return $this->entity_map->get($class, $class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function supports(ParamConverter $configuration) {
		$original_class = $configuration->getClass();
		// Replace the class with our resolved class
		$configuration->setClass($this->resolveClass($original_class));

		if (parent::supports($configuration)) {
			return true;
		}
		else {
			// Reset our changes
			$configuration->setClass($original_class);
			return false;
		}
	}
} 