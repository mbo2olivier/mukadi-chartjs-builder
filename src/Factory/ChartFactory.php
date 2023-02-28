<?php
namespace Mukadi\Chart\Factory;

use Mukadi\Chart\Fetcher\DataFetcher;
use Mukadi\Chart\DataFetcherInterface;
use Mukadi\Chart\DefinitionProviderInterface;
use Mukadi\Chart\Provider\DefaultDefinitionProvider;

class ChartFactory extends AbstractChartFactory {

    public function __construct(protected \PDO $connection)
    {
        parent::__construct(new DefaultDefinitionProvider());
    }

    public function getDataFetcher(): DataFetcherInterface
    {
        return new DataFetcher($this->connection);
    }

    public function overrideDefinitionProvider(DefinitionProviderInterface $provider): self {
        $this->provider = $provider;

        return $this;
    }
}