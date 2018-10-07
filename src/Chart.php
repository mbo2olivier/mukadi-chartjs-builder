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
 * Class Chart.
 * 
 * @author Olivier M. Mukadi <olivier.m@geniusconception.com>
 */
class Chart  
{
    const BAR = 'bar';
    const LINE = 'line';
    const RADAR = 'radar';
    const POLAR_AREA = 'polarArea';
    const BUBBLE = 'bar';
    const PIE = 'pie';
    const DOUGHNUT = 'doughnut';

    /**
     * @var string
     */
    protected $id;
    /**
     * @var array
     */
    protected $options;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var array
     */
    protected $datasets;
    /**
     * @var array
     */
    protected $labels;

    /**
     * @param string $id
     */
    public function __construct($id){
        $this->id = $id;
        $this->type = self::BAR;
        $this->labels = array();
        $this->datasets = array();
        $this->options = array(
            "scales"=>array(
                "yAxes" => array(
                    array(
                        "ticks"=> array("beginAtZero"=>true)
                    )
                )
            )
        );
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getDatasets()
    {
        return $this->datasets;
    }

    /**
     * @param array $datasets
     *
     * @return Chart
     */
    public function setDatasets($datasets)
    {
        $this->datasets = $datasets;

        return $this;
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param array $labels
     *
     * @return Chart
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Chart
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function pushOptions($options = array()){
        $this->options = array_merge($this->options,$options);

        return $this;
    }

    public function __toString() {
        $html = '<div class="mukadi_chartJs_container" data-labels="%s" data-target="%s" data-datasets="%s" data-options="%s" data-chart-type="%s"><canvas id="%s"></canvas></div>';
        return sprintf($html, htmlspecialchars(json_encode($this->getLabels())),$this->getId(),htmlspecialchars(json_encode($this->getDatasets())),htmlspecialchars(json_encode($this->getOptions())),$this->getType(),$this->getId());
    }
}
