<?php
namespace Mukadi\Chart;

use Mukadi\Chart\Type\Chart;

interface ChartDefinitionBuilderInterface {

    function asBar(): Chart;
    function asPie(): Chart;
    function asLine(): Chart;
    function asDoughnut(): Chart;
    function asPolarArea(): Chart;
    function asRadar(): Chart;
    function asBubble(): Chart;
    function asScatter(): Chart;
}