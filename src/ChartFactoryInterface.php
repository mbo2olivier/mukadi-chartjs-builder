<?php
namespace Mukadi\Chart;

interface ChartFactoryInterface {

    function createFromDefinition(ChartDefinitionInterface $definition): ChartBuilder;
    
    function createChartBuilder(): ChartBuilder;
}