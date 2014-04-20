<?php

namespace Vivait\ResolveEntityBundle\Service;

class EntityMapService {
	/**
	 * @var array
	 */
	private $map = array();

	/**
	 * Adds a target-entity class name to resolve to a new class name.
	 *
	 * @param string $originalEntity
	 * @param string $newEntity
	 *
	 * @return $this
	 */
	public function add($originalEntity, $newEntity) {
		$this->map[ltrim($originalEntity, "\\")] = ltrim($newEntity, "\\");

		return $this;
	}

	/**
	 * @param $entity
	 * @return $this
	 */
	public function remove($entity) {
		unset($this->map[$entity]);
		return $this;
	}

	/**
	 * @param $entity
	 * @return bool
	 */
	public function has($entity) {
		return isset($this->map[$entity]);
	}

	/**
	 * @param $entity
	 * @param null $default
	 * @return null
	 */
	public function get($entity, $default = null) {
		return ($this->has($entity)) ? $this->map[$entity] : $default;
	}
} 