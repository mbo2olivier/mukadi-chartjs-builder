<?php
/**
 * This file is part of the mukadi/chart-builder package
 * (c) 2018 Genius Conception
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mukadi\Chart;
/**
 * Class ChartView.
 * 
 * @author Olivier M. Mukadi <olivier.m@geniusconception.com>
 */
class ChartView  
{
    const BAR = 'bar';
    const LINE = 'line';
    const RADAR = 'radar';
    const POLAR_AREA = 'polarArea';
    const BUBBLE = 'bubble';
    const SCATTER = 'scatter';
    const PIE = 'pie';
    const DOUGHNUT = 'doughnut';

    /**
     * @var string
     */
    protected string $id;
    /**
     * @var array
     */
    protected array $options;
    /**
     * @var string
     */
    protected string $type;
    /**
     * @var array
     */
    protected array $datasets;
    /**
     * @var array
     */
    protected array $labels;

    public function __construct(string $type){
        $this->id = "";
        $this->type = $type;
        $this->labels = array();
        $this->datasets = array();
        $this->options = array(
            "scales" => [
                "y" => [
                    "beginAtZero" => true,
                ]
            ]
        );
    }

    /**
     * @return mixed
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getDatasets(): array
    {
        return $this->datasets;
    }

    /**
     * @param array $datasets
     *
     * @return Chart
     */
    public function setDatasets($datasets): self
    {
        $this->datasets = $datasets;

        return $this;
    }

    /**
     * @return array
     */
    public function getLabels():array
    {
        return $this->labels;
    }

    /**
     * @param array $labels
     *
     * @return Chart
     */
    public function setLabels($labels): self
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * @return string
     */
    public function getType():string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Chart
     */
    public function setType($type):string
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions():array
    {
        return $this->options;
    }

    public function pushOptions($options = array()): self{
        $this->options = array_merge($this->options,$options);

        return $this;
    }

    public function __toString() {
        $html = '<div class="mukadi_chartJs_container" data-labels="%s" data-target="%s" data-datasets="%s" data-options="%s" data-chart-type="%s"><canvas id="%s"></canvas></div>';
        return sprintf($html, htmlspecialchars(json_encode($this->getLabels())),$this->getId(),htmlspecialchars(json_encode($this->getDatasets())),htmlspecialchars(json_encode($this->getOptions())),$this->getType(),$this->getId());
    }

    /**
     * Set the value of id
     *
     * @param  string  $id
     *
     * @return  self
     */ 
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }
}
