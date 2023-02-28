<?php
namespace Mukadi\Chart\Type;

use Mukadi\Chart\ChartBuilderInterface;
use Mukadi\Chart\ChartData;
use Mukadi\Chart\Utils\RandomColorFactory;

class SimpleChart extends AbstractChart {

    use ChartTrait;

    protected array|string $labels;
    protected array $datasets;

    public function __construct(protected string $type, protected ChartBuilderInterface $buider)
    {
        parent::__construct($buider);
        $this->resetData();
    }

    public function dataset(string $label = ""): self {
        if (!$this->canOpenDataset) throw new \LogicException('nested dataset is not allowed, end the previous dataset first');

        $this->canOpenDataset = false;
        $this->_dataset = [
            "label" => $label,
        ];

        return $this;
    }

    public function data(string $key): self {
        if ($this->canOpenDataset) throw new \LogicException('operation not allowed, open a new dataset first.');

        $this->_dataset['data'] = $key;

        return $this;
    }

    public function options(array $options): self {
        if ($this->canOpenDataset) throw new \LogicException('operation not allowed, open a new dataset first.');

        $this->_dataset['options'] = $options;

        return $this;
    }

    public function end():self {
        if ($this->canOpenDataset) throw new \LogicException('operation not allowed, open a new dataset first.');

        if (!isset($this->_dataset['data'])) throw new \LogicException('missing data key');
        $key = $this->_dataset['data'];

        $this->datasets[$key] = [
            "label" => $this->_dataset['label'],
        ];
        
        if (isset($this->_dataset['options'])) {
            $this->datasets[$key] = array_merge($this->datasets[$key],$this->_dataset['options']);
        }

        $this->resetData();

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

        $this->labels = $labels;
        $this->hasLabels = true;
        $this->resetData();

        return new ChartData($this->type, $this->labels, $this->datasets);
    }
}