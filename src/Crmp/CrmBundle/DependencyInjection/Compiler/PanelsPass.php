<?php

namespace Crmp\CrmBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiller pass to build up panels.
 *
 * Panels are used especially while looking at single entities.
 * Other entities shall be allowed to place related information
 * below the major information about the current entity.
 *
 * @package Crmp\CrmBundle\DependencyInjection\Compiler
 */
class PanelsPass implements CompilerPassInterface
{
    protected $mapServiceTag    = 'crmp.panel';
    protected $targetMethod     = 'add';
    protected $targetServiceTag = 'crmp.panel_group';

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $mapServices = array();
        foreach ($container->findTaggedServiceIds($this->getMapServiceTag()) as $id => $tags) {
            foreach ($tags as $eachTag) {
                $targetId = $eachTag['target'];

                if (empty($mapServices[$targetId])) {
                    $mapServices[$targetId] = array();
                }

                $mapServices[$targetId][] = $id;
            }
        }

        if (empty($mapServices)) {
            return;
        }

        foreach ($container->findTaggedServiceIds($this->getTargetServiceTag()) as $id => $tags) {
            foreach ($tags as $eachTag) {
                $alias = $eachTag['alias'];

                if (! empty($mapServices[$alias])) {
                    $targetDefinition = $container->getDefinition($id);

                    foreach ($mapServices[$alias] as $eachMapServiceId) {
                        $targetDefinition->addMethodCall('setContainer', [new Reference('service_container')]);
                        $targetDefinition->addMethodCall(
                            $this->getTargetMethod(),
                            $this->getArguments($eachMapServiceId)
                        );
                    }
                }
            }
        }
    }

    protected function getMapServiceTag()
    {
        return $this->mapServiceTag;
    }

    protected function getTargetServiceTag()
    {
        return $this->targetServiceTag;
    }

    protected function getTargetMethod()
    {
        return $this->targetMethod;
    }

    /**
     * Return the argument list on the target method for a single service.
     *
     * @param string $id
     *
     * @return array
     */
    protected function getArguments($id)
    {
        return [new Reference($id)];
    }
}
