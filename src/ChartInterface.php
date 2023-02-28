<?php
namespace Mukadi\Chart;

interface ChartInterface {

    function build():ChartBuilderInterface;

    function compute(iterable $data): ChartData;

    function getQuery(): string;
}