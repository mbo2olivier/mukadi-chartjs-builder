<?php
namespace Mukadi\Chart;

interface DefinitionProviderInterface {

    function provide(string $fcqn): ChartDefinitionInterface;
}