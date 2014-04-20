<?php

namespace spec\Vivait\ResolveEntityBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VivaitResolveEntityBundleSpec extends ObjectBehavior {
	function it_is_initializable() {
		$this->shouldHaveType('Symfony\Component\HttpKernel\Bundle\Bundle');
	}
}
