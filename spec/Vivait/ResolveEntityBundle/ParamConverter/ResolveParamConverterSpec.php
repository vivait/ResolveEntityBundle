<?php

namespace spec\Vivait\ResolveEntityBundle\ParamConverter;

use Doctrine\Common\Persistence\ManagerRegistry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vivait\ResolveEntityBundle\ParamConverter\ResolveParamConverter;
use Vivait\ResolveEntityBundle\Service\EntityMapService;

/**
 * @mixin ResolveParamConverter
 */
class ResolveParamConverterSpec extends ObjectBehavior {
	function let(ManagerRegistry $registry, EntityMapService $entity_map) {
		$entity_map->has('MappedInterface')
			->willReturn(true);
		$entity_map->get('MappedInterface', Argument::any())
			->willReturn('MappedEntity');

		$entity_map->has('MappedAbstract')
			->willReturn(true);
		$entity_map->get('MappedAbstract', Argument::any())
			->willReturn('AnotherEntity');

		$entity_map->get('ConcreteEntity', Argument::any())
			->will(function($args) {
				return $args[1];
			});

		$this->beConstructedWith($registry, $entity_map);
	}

	function it_should_resolve_a_class() {
		$this->resolveClass('MappedAbstract')
			->shouldReturn('AnotherEntity');
	}

	function it_should_resolve_non_existent_classes() {
		$this->resolveClass('ConcreteEntity')
			->shouldReturn('ConcreteEntity');
	}
}
