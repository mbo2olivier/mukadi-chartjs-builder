<?php
namespace Mukadi\Chart;

interface ChartBuilderInterface {

    function setParameter(string $key, $value): self;

    function getChart(array $options = []): ChartView;

}