<?php
namespace Mukadi\Chart\Factory;

use Mukadi\Chart\ChartBuilder;
use Mukadi\Chart\ChartDefinitionInterface;
use Mukadi\Chart\ChartFactoryInterface;
use Mukadi\Chart\DataFetcherInterface;
use Mukadi\Chart\DefinitionProviderInterface;

abstract class AbstractChartFactory implements ChartFactoryInterface {

    public function __construct(protected DefinitionProviderInterface $provider)
    {
        
    }

    abstract function getDataFetcher():DataFetcherInterface;

    public function createChartBuilder(): ChartBuilder
    {
        return new ChartBuilder($this->getDataFetcher());
    }

    public function createFromDefinition(ChartDefinitionInterface|string $definition): ChartBuilder
    {
        if (is_string($definition)) {
            $definition = $this->provider->provide($definition);
        }

        $builder = $this->createChartBuilder();
        $definition->define($builder);

        return $builder;
    }
}