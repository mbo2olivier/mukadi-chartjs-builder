<?php
namespace Mukadi\Chart;

interface ChartInterface {

    function build():ChartBuilderInterface;

    function compute(\Traversable $data): ChartData;

    function getQuery(): string;
}