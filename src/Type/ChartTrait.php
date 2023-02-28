<?php
namespace Mukadi\Chart\Type;

trait ChartTrait {

    public function query(string $sql): self
    {
        $this->q = $sql;

        return $this;
    }

    public function labels(array|string $labels, $func = null): self
    {
        $this->labels = $labels;
        $this->labelFunc = $func;
        if(is_array($labels)) {
            $this->hasLabels = true;
        }else{
            $this->hasLabels = false;
        }
        return $this;
    }

    function useRandomBackgroundColor(bool $alpha = true):self {
        if ($this->canOpenDataset) throw new \LogicException('operation not allowed, open a new dataset first.');

        $this->_dataset['options']['backgroundColor'] = true;
        $this->_dataset['options']['backgroundColorAlpha'] = $alpha;

        return $this;
    }

    function useRandomBorderColor(bool $alpha = true):self {
        if ($this->canOpenDataset) throw new \LogicException('operation not allowed, open a new dataset first.');

        $this->_dataset['options']['borderColor'] = true;
        $this->_dataset['options']['borderColorAlpha'] = $alpha;

        return $this;
    }

    function useRandomHoverBackgroundColor(bool $alpha = true):self {
        if ($this->canOpenDataset) throw new \LogicException('operation not allowed, open a new dataset first.');

        $this->_dataset['options']['hoverBackgroundColor'] = true;
        $this->_dataset['options']['hoverBackgroundColorAlpha'] = $alpha;

        return $this;
    }

    function useRandomHoverBorderColor(bool $alpha = true):self {
        if ($this->canOpenDataset) throw new \LogicException('operation not allowed, open a new dataset first.');

        $this->_dataset['options']['hoverBorderColor'] = true;
        $this->_dataset['options']['hoverBackgroundColorAlpha'] = $alpha;

        return $this;
    }
}