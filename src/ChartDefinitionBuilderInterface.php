<?php
namespace Mukadi\Chart;

use Mukadi\Chart\Type\SimpleChart;

interface ChartDefinitionBuilderInterface {

    function asBar(): SimpleChart;
    function asPie(): SimpleChart;
    function asLine(): SimpleChart;
    function asDoughnut(): SimpleChart;
    function asPolarArea(): SimpleChart;
    function asRadar(): SimpleChart;
}