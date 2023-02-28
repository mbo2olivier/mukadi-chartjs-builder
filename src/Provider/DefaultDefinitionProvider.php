<?php
namespace Mukadi\Chart\Provider;

use Mukadi\Chart\ChartDefinitionInterface;
use Mukadi\Chart\DefinitionProviderInterface;

class DefaultDefinitionProvider implements DefinitionProviderInterface {

    public function provide(string $fcqn): ChartDefinitionInterface
    {
        if (!is_subclass_of($fcqn, ChartDefinitionInterface::class)) {
            throw new \InvalidArgumentException(sprintf('%s is no implementing the %s', $fcqn, ChartDefinitionInterface::class));
        }

        return new $fcqn();
    }
}