<?php
namespace Mukadi\Chart\Type;

use Mukadi\Chart\ChartBuilderInterface;
use Mukadi\Chart\ChartInterface;

abstract class Chart implements ChartInterface {

    protected string $q;
    protected bool $hasLabels;
    protected array|string $labels;
    protected $labelFunc;
    protected bool $canOpenDataset;

    public function __construct(protected string $type, protected ChartBuilderInterface $builder)
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

    public function dataset(string $label = ""): DatasetConfiguratorInterface {
        return new DatasetConfigurator($this, $label);
    }

    public abstract function end(DatasetConfigurator $config): self;
}