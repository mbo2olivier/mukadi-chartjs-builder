<?php
namespace Mukadi\Chart\Type;

use Mukadi\Chart\ChartBuilderInterface;
use Mukadi\Chart\ChartData;
use Mukadi\Chart\ChartView;
use Mukadi\Chart\Utils\RandomColorFactory;

class ScatterChart extends Chart {

    private array $datasets;

    public function __construct(ChartBuilderInterface $builder)
    {
        parent::__construct(ChartView::SCATTER, $builder);
        $this->datasets = [];
    }

    public function end(DatasetConfigurator $config): Chart
    {
        $config->_data = array_values($config->_data);
        $count = count($config->_data);
        if ($count != 2) {
            throw new \InvalidArgumentException(sprintf('two data keys expected , %d found', $count));
        }

        $d = [
            "label" => $config->_label,
            "_xy" => $config->_data,
        ];

        $this->datasets[] = array_merge($d, $config->_options);

        return $this;
    }

    public function compute(iterable $data): ChartData
    {
        foreach ($data as $input) {
            $len = count($this->datasets);
            for($i = 0; $i < $len; $i++) {
                $xyr = $this->datasets[$i]["_xy"];

                $this->datasets[$i]['data'][] = [
                    "x" => $input[$xyr[0]],
                    "y" => $input[$xyr[1]],
                ];
            }
        }

        $len = count($this->datasets);
        for($k = 0; $k < $len; $k++) {
            if (isset($this->datasets[$k]['backgroundColor']) && $this->datasets[$k]['backgroundColor'] === true) {
                $this->datasets[$k]['backgroundColor'] = $this->datasets[$k]['backgroundColorAlpha'] === true ? RandomColorFactory::randomRGBAColor() : RandomColorFactory::randomRGBColor();
                unset($this->datasets[$k]['backgroundColorAlpha']);
            }
            if (isset($this->datasets[$k]['borderColor']) && $this->datasets[$k]['borderColor'] === true) {
                $this->datasets[$k]['borderColor'] = $this->datasets[$k]['borderColorAlpha'] === true ? RandomColorFactory::randomRGBAColor() : RandomColorFactory::randomRGBColor();
                unset($this->datasets[$k]['borderColorAlpha']);
            }
            if (isset($this->datasets[$k]['hoverBackgroundColor']) && $this->datasets[$k]['hoverBackgroundColor'] === true) {
                $this->datasets[$k]['hoverBackgroundColor'] = $this->datasets[$k]['hoverBackgroundColorAlpha'] === true ? RandomColorFactory::randomRGBAColor() : RandomColorFactory::randomRGBColor();
                unset($this->datasets[$k]['hoverBackgroundColorAlpha']);
            }
            if (isset($this->datasets[$k]['hoverBorderColor']) && $this->datasets[$k]['hoverBorderColor'] === true) {
                $this->datasets[$k]['hoverBorderColor'] = $this->datasets[$k]['hoverBorderColorAlpha'] === true ? RandomColorFactory::randomRGBAColor() : RandomColorFactory::randomRGBColor();
                unset($this->datasets[$k]['hoverBorderColorAlpha']);
            }

            unset($this->datasets[$k]["_xy"]);
        }

        return new ChartData($this->type, [], $this->datasets);
    }
}