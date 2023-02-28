<?php
namespace Mukadi\Chart;

interface DataFetcherInterface {

    function execute(string $sql, array $vars = []): iterable;
}