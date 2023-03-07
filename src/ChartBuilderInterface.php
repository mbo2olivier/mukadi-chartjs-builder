<?php
namespace Mukadi\Chart;

interface ChartBuilderInterface {

    function setOptions(array $options): self;

    function setParameter(string $key, $value): self;

    function getChart(array $options = []): ChartView;

}