<?php
namespace Mukadi\Chart;

use Mukadi\Chart\Type\BubbleChart;
use Mukadi\Chart\Type\Chart;
use Mukadi\Chart\Type\ScatterChart;
use Mukadi\Chart\Type\SimpleChart;

class ChartBuilder implements ChartBuilderInterface, ChartDefinitionBuilderInterface {

    protected ?ChartInterface $chart;
    protected array $vars;

    public function __construct(protected DataFetcherInterface $fetcher)
    {
        $this->chart = null;
        $this->vars = [];
    }

    public function setParameter(string $key, $value): ChartBuilderInterface
    {
        $this->vars[$key] = $value;

        return $this;
    }

    public function getChart(array $options = []): ChartView
    {
        if ($this->chart === null) throw new \LogicException('Cannot create chart: Missing definition');
        
        $results = $this->fetcher->execute($this->chart->getQuery(), $this->vars);
        $data = $this->chart->compute($results);

        $c = new ChartView($data->getType());
        $c->setLabels($data->getLabels());
        $c->setDatasets(array_values($data->getDatasets()));
        if(is_array($options)) $c->pushOptions($options);

        return $c;
    }

    public function asBar(): Chart
    {
        $this->chart = new SimpleChart(ChartView::BAR, $this);
        return $this->chart;
    }

    public function asPie(): Chart
    {
        $this->chart = new SimpleChart(ChartView::PIE, $this);
        return $this->chart;
    }

    public function asDoughnut(): Chart
    {
        $this->chart = new SimpleChart(ChartView::DOUGHNUT, $this);
        return $this->chart;
    }

    public function asLine(): Chart
    {
        $this->chart = new SimpleChart(ChartView::LINE, $this);
        return $this->chart;
    }

    public function asPolarArea(): Chart
    {
        $this->chart = new SimpleChart(ChartView::POLAR_AREA, $this);
        return $this->chart;
    }

    public function asRadar(): Chart
    {
        $this->chart = new SimpleChart(ChartView::RADAR, $this);
        return $this->chart;
    }

    public function asBubble(): Chart {
        $this->chart = new BubbleChart($this);

        return $this->chart;
    }

    public function asScatter(): Chart {
        $this->chart = new ScatterChart($this);

        return $this->chart;
    }
}