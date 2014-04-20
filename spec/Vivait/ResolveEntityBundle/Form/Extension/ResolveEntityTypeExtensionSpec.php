<?php

namespace spec\Vivait\ResolveEntityBundle\Form\Extension;

use Doctrine\Common\Persistence\ManagerRegistry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vivait\ResolveEntityBundle\Form\Extension\ResolveEntityTypeExtension;
use Vivait\ResolveEntityBundle\Service\EntityMapService;

/**
 * @mixin ResolveEntityTypeExtension
 */
class ResolveEntityTypeExtensionSpec extends ObjectBehavior {

	function let(ManagerRegistry $registry, EntityMapService $entity_map) {
		$this->beConstructedWith($registry, $entity_map);
	}

	function it_is_a_type_extension() {
		$this->shouldHaveType('Symfony\Component\Form\AbstractTypeExtension');
	}

	function it_should_extend_the_entity_type() {
		$this->getExtendedType()
			->shouldReturn('entity');
	}

	function it_should_register_a_custom_normalizer(OptionsResolverInterface $resolver) {
		$resolver->setNormalizers(Argument::any())
			->shouldBeCalled();

		$this->setDefaultOptions($resolver);
	}
}
