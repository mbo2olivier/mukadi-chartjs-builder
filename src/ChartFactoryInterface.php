<?php
namespace Mukadi\Chart;

interface ChartFactoryInterface {

    function createFromDefinition(ChartDefinitionInterface|string $definition): ChartBuilder;
    
    function createChartBuilder(): ChartBuilder;
}