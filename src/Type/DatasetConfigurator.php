<?php
namespace Mukadi\Chart\Type;

class DatasetConfigurator {

    public array $_data;
    public array $_options;

    public function __construct(private Chart $chart, public string $_label)
    {
        $this->_options = [];
    }

    public function data(): self {
        $this->_data = func_get_args();

        return $this;
    }

    public function options(array $options): self {
        $this->_options = $options;

        return $this;
    }
    
    public function end(): Chart {

        return $this->chart->end($this);
    }

    function useRandomBackgroundColor(bool $alpha = true):self {
        $this->_options['backgroundColor'] = true;
        $this->_options['backgroundColorAlpha'] = $alpha;

        return $this;
    }

    function useRandomBorderColor(bool $alpha = true):self {
        $this->_options['borderColor'] = true;
        $this->_options['borderColorAlpha'] = $alpha;

        return $this;
    }

    function useRandomHoverBackgroundColor(bool $alpha = true):self {

        $this->_options['hoverBackgroundColor'] = true;
        $this->_options['hoverBackgroundColorAlpha'] = $alpha;

        return $this;
    }

    function useRandomHoverBorderColor(bool $alpha = true):self {

        $this->_options['hoverBorderColor'] = true;
        $this->_options['hoverBackgroundColorAlpha'] = $alpha;

        return $this;
    }
}