<?php

namespace Vivait\ResolveEntityBundle\Form\Extension;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResolveEntityTypeExtension extends AbstractTypeExtension
{
	/**
	 * @var ManagerRegistry
	 */
	protected $registry;

	/**
	 * @var array
	 */
	private $resolveTargetEntities = array();

	function __construct($registry) {
		$this->registry = $registry;
	}

	/**
	 * Adds a target-entity class name to resolve to a new class name.
	 *
	 * @param string $originalEntity
	 * @param string $newEntity
	 *
	 * @return void
	 */
	public function addResolveTargetEntity($originalEntity, $newEntity)
	{
		$this->resolveTargetEntities[ltrim($originalEntity, "\\")] = ltrim($newEntity, "\\");
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolveTargetEntities = $this->resolveTargetEntities;
		$registry              = $this->registry;

		$classNormalizer = function (Options $options, $class) use ($resolveTargetEntities, $registry) {
			// Check for namespace alias
			if (strpos($class, ':') !== false) {
				list($namespaceAlias, $simpleClassName) = explode(':', $class);
				$class = $registry->getAliasNamespace($namespaceAlias) . '\\' . $simpleClassName;
			}

			return (isset($resolveTargetEntities[$class])) ? $resolveTargetEntities[$class] : $class;
		};

		$resolver->setNormalizers(array(
			'class' => $classNormalizer
		));
	}

	/**
	 * Returns the name of the type being extended.
	 *
	 * @return string The name of the type being extended
	 */
	public function getExtendedType()
	{
		return 'entity';
	}
}
