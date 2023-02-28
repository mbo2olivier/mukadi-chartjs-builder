<?php
namespace Mukadi\Chart\Type;

use Mukadi\Chart\ChartView;

class DatasetConfigurator implements DatasetConfiguratorInterface {

    public array $_data;
    public array $_options;
    public string|null $_type;

    public function __construct(private Chart $chart, public string $_label)
    {
        $this->_options = [];
        $this->_type = null;
    }

    public function data(): DatasetConfiguratorInterface {
        $this->_data = func_get_args();

        return $this;
    }

    public function options(array $options): DatasetConfiguratorInterface {
        $this->_options = $options;

        return $this;
    }
    
    public function end(): Chart {

        return $this->chart->end($this);
    }

    public function useRandomBackgroundColor(bool $alpha = true):DatasetConfiguratorInterface {
        $this->_options['backgroundColor'] = true;
        $this->_options['backgroundColorAlpha'] = $alpha;

        return $this;
    }

    public function useRandomBorderColor(bool $alpha = true):DatasetConfiguratorInterface {
        $this->_options['borderColor'] = true;
        $this->_options['borderColorAlpha'] = $alpha;

        return $this;
    }

    public function useRandomHoverBackgroundColor(bool $alpha = true):DatasetConfiguratorInterface {

        $this->_options['hoverBackgroundColor'] = true;
        $this->_options['hoverBackgroundColorAlpha'] = $alpha;

        return $this;
    }

    public function useRandomHoverBorderColor(bool $alpha = true):DatasetConfiguratorInterface {

        $this->_options['hoverBorderColor'] = true;
        $this->_options['hoverBackgroundColorAlpha'] = $alpha;

        return $this;
    }

    public function asBar(): DatasetConfiguratorInterface {
        $this->_type = ChartView::BAR;

        return $this;
    }

    public function asLine(): DatasetConfiguratorInterface {
        $this->_type = ChartView::LINE;

        return $this;
    }

    public function asPolarArea(): DatasetConfiguratorInterface {
        $this->_type = ChartView::POLAR_AREA;

        return $this;
    }

    public function asPie(): DatasetConfiguratorInterface {
        $this->_type = ChartView::PIE;

        return $this;
    }

    public function asDoughnut(): DatasetConfiguratorInterface {
        $this->_type = ChartView::DOUGHNUT;

        return $this;
    }

    public function asRadar(): DatasetConfiguratorInterface {
        $this->_type = ChartView::RADAR;

        return $this;
    }
}