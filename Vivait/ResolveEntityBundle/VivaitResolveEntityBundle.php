<?php

namespace Vivait\ResolveEntityBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Vivait\ResolveEntityBundle\DependencyInjection\Compiler\OverrideServicesCompilerPass;

class VivaitResolveEntityBundle extends Bundle {
	public function build(ContainerBuilder $container) {
		parent::build($container);

		//$container->addCompilerPass(new OverrideServicesCompilerPass());
	}
}