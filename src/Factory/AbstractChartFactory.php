<?php
namespace Mukadi\Chart\Factory;

use Mukadi\Chart\ChartBuilder;
use Mukadi\Chart\ChartDefinitionInterface;
use Mukadi\Chart\ChartFactoryInterface;
use Mukadi\Chart\DataFetcherInterface;

abstract class AbstractChartFactory implements ChartFactoryInterface {

    abstract function getDataFetcher():DataFetcherInterface;

    public function createChartBuilder(): ChartBuilder
    {
        return new ChartBuilder($this->getDataFetcher());
    }

    public function createFromDefinition(ChartDefinitionInterface $definition): ChartBuilder
    {
        $builder = $this->createChartBuilder();
        $definition->define($builder);

        return $builder;
    }
}