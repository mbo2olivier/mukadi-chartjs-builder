<?php
namespace Mukadi\Chart\Type;

use Mukadi\Chart\ChartBuilderInterface;
use Mukadi\Chart\ChartInterface;

abstract class AbstractChart implements ChartInterface {

    protected string $q;
    protected bool $hasLabels;
    protected array|string $labels;
    protected $labelFunc;
    protected bool $canOpenDataset;
    protected array $_dataset;

    public function __construct(protected ChartBuilderInterface $builder)
    {
        
    }

    public function build(): ChartBuilderInterface
    {
        return $this->builder;
    }

    public function getQuery(): string
    {
        return $this->q;
    }

    protected function resetData():void {
        $this->_dataset = [
        ];
        $this->canOpenDataset = true;
    }
}