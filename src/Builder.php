<?php
/**
 * This file is part of the mukadi/chartjs-builder
 * (c) 2018 Genius Conception
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Mukadi\Chart;
/**
 * Class Builder.
 * 
 * @author Olivier M. Mukadi <olivier.m@geniusconception.com>
 */
class Builder extends AbstractBuilder
{
    /** @var \PDO */
    protected $connection;

    /** @var array $vars  */
    protected $vars;

    /** @var string $query  */
    protected $q;

    public function __construct(\PDO $connection) {
        $this->connection = $connection;
        $this->vars = [];
        $this->q = null;
    }
    
    public function query($query) {
        $this->q = $query;
        return $this;
    }

    public function setParameter($key, $value) {
        $this->vars[$key] = $value;
        return $this;
    }

    protected function getData() {
        if (count($this->vars) > 0) {
            $s = $this->connection->prepare($this->q);
            $s->execute($this->vars);
            return $s->fetchAll();
        }else{
            return $this->connection->query($this->q);
        }
    }
}
