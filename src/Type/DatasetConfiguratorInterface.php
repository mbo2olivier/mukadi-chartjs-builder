<?php
namespace Mukadi\Chart\Type;

interface DatasetConfiguratorInterface {

    function data(): self;
    function options(array $options): self;
    function end(): Chart;
    function useRandomBackgroundColor(bool $alpha = true):self;
    function useRandomBorderColor(bool $alpha = true):self;
    function useRandomHoverBackgroundColor(bool $alpha = true):self;
    function useRandomHoverBorderColor(bool $alpha = true):self;
    function asBar(): self;
    function asPie(): self;
    function asLine(): self;
    function asDoughnut(): self;
    function asPolarArea(): self;
    function asRadar(): self;
}