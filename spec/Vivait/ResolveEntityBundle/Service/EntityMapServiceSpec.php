<?php

namespace spec\Vivait\ResolveEntityBundle\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vivait\ResolveEntityBundle\Service\EntityMapService;

/**
 * @mixin EntityMapService
 */
class EntityMapServiceSpec extends ObjectBehavior
{
	function it_will_return_a_mapped_entity() {
		$this->add('EntityInterface', 'MyEntity')
			->shouldReturn($this);

		$this->has('EntityInterface')
			->shouldReturn(true);

		$this->get('EntityInterface')
			->shouldReturn('MyEntity');
	}

	function it_will_handle_non_existent_entities_gracefully() {
		$this->has('IdontExistInterface')
			->shouldReturn(false);

		$this->get('IdontExistInterface')
			->shouldReturn(null);
	}

	function it_will_remove_an_entity() {
		$this->add('EntityInterface', 'MyEntity')
			->shouldReturn($this);

		$this->has('EntityInterface')
			->shouldReturn(true);

		$this->remove('EntityInterface')
			->shouldReturn($this);

		$this->has('EntityInterface')
			->shouldReturn(false);
	}
}
