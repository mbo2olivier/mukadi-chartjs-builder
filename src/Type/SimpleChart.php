<?php
namespace Mukadi\Chart\Type;

use Mukadi\Chart\ChartBuilderInterface;
use Mukadi\Chart\ChartData;
use Mukadi\Chart\Utils\RandomColorFactory;

class SimpleChart extends Chart {


    private array $datasets;

    public function __construct(string $type, ChartBuilderInterface $buider)
    {
        parent::__construct($type, $buider);
        $this->datasets = [];
    }

    public function end(DatasetConfigurator $config):self {
        $config->_data = array_values($config->_data);
        $count = count($config->_data);
        if ($count != 1) {
            throw new \InvalidArgumentException(sprintf('one data key expected , %d found', $count));
        }

        $key = $config->_data[0];        

        $this->datasets[$key] = [
            "label" => $config->_label,
        ];
        
        $this->datasets[$key] = array_merge($this->datasets[$key], $config->_options);

        return $this;
    }

    public function compute(iterable $data): ChartData
    {
        $keys = array_keys($this->datasets);
        $labels = $this->hasLabels? $this->labels: [];
        $i = 0;
        foreach ($data as $input) {
            if (!$this->hasLabels) {
                $labels[] = ($this->labelFunc) ?  \call_user_func($this->labelFunc, $input[$this->labels]): $input[$this->labels];
            }
            foreach($keys as $k) {
                $this->datasets[$k]['data'][] = $input[$k];
            }
            $i++;
        }

        foreach ($keys as $k) {
            if (isset($this->datasets[$k]['backgroundColor']) && $this->datasets[$k]['backgroundColor'] === true) {
                $this->datasets[$k]['backgroundColor'] = $this->datasets[$k]['backgroundColorAlpha'] === true ? RandomColorFactory::getRandomRGBAColors($i) : RandomColorFactory::getRandomColors($i);
                unset($this->datasets[$k]['backgroundColorAlpha']);
            }
            if (isset($this->datasets[$k]['borderColor']) && $this->datasets[$k]['borderColor'] === true) {
                $this->datasets[$k]['borderColor'] = $this->datasets[$k]['borderColorAlpha'] === true ? RandomColorFactory::getRandomRGBAColors($i) : RandomColorFactory::getRandomColors($i);
                unset($this->datasets[$k]['borderColorAlpha']);
            }
            if (isset($this->datasets[$k]['hoverBackgroundColor']) && $this->datasets[$k]['hoverBackgroundColor'] === true) {
                $this->datasets[$k]['hoverBackgroundColor'] = $this->datasets[$k]['hoverBackgroundColorAlpha'] === true ? RandomColorFactory::getRandomRGBAColors($i) : RandomColorFactory::getRandomColors($i);
                unset($this->datasets[$k]['hoverBackgroundColorAlpha']);
            }
            if (isset($this->datasets[$k]['hoverBorderColor']) && $this->datasets[$k]['hoverBorderColor'] === true) {
                $this->datasets[$k]['hoverBorderColor'] = $this->datasets[$k]['hoverBorderColorAlpha'] === true ? RandomColorFactory::getRandomRGBAColors($i) : RandomColorFactory::getRandomColors($i);
                unset($this->datasets[$k]['hoverBorderColorAlpha']);
            }
        }
        
        return new ChartData($this->type, $labels, $this->datasets);
    }
}