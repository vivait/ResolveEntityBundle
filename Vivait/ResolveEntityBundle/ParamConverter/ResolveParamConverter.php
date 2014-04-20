<?php

namespace Vivait\ResolveEntityBundle\ParamConverter;

use Doctrine\Common\Persistence\ManagerRegistry;
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
		// Check for namespace alias
		if (strpos($class, ':') !== false) {
			list($namespaceAlias, $simpleClassName) = explode(':', $class);
			$class = $this->registry->getAliasNamespace($namespaceAlias) . '\\' . $simpleClassName;
		}

		return $this->entity_map->get($class, $class);
	}

	protected function getManager($name, $class) {
		if (null === $name) {
			return $this->registry->getManagerForClass($this->resolveClass($class));
		}

		return $this->registry->getManager($name);
	}
} 