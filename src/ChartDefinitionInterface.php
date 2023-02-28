<?php
namespace Mukadi\Chart;

interface ChartDefinitionInterface {

    function define(ChartDefinitionBuilderInterface $builder):void;
}