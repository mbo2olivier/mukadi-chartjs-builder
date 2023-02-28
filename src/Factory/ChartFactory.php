<?php
namespace Mukadi\Chart\Factory;

use Mukadi\Chart\Fetcher\DataFetcher;
use Mukadi\Chart\DataFetcherInterface;

class ChartFactory extends AbstractChartFactory {

    public function __construct(protected \PDO $connection)
    {
        
    }

    public function getDataFetcher(): DataFetcherInterface
    {
        return new DataFetcher($this->connection);
    }
}