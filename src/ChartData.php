<?php
namespace Mukadi\Chart;

class ChartData {

    public function __construct(
        private string $type,
        private array $labels,
        private array $datasets,
    )
    {
        
    }

    /**
     * Get the value of labels
     */ 
    public function getLabels(): array
    {
            return $this->labels;
    }

    /**
     * Get the value of datasets
     */ 
    public function getDatasets():array
    {
            return $this->datasets;
    }

    /**
     * Get the value of type
     */ 
    public function getType(): string
    {
            return $this->type;
    }
}