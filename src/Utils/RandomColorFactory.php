<?php
/**
* This file is part of the mukadi/chart-builder package
* (c) 2018 Genius Conception
* 
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace Mukadi\Chart\Utils;
/**
* Class Chart.
* 
* @author Olivier M. Mukadi <olivier.m@geniusconception.com>
*/
class RandomColorFactory {

    /**
     * @return int
     */
    public static function randomColorFactor(){
        return rand(0,255);
    }

    /**
     * @return string
     */
    public static function randomRGBColor(){
        return sprintf("rgb(%d,%d,%d)",self::randomColorFactor(),self::randomColorFactor(),self::randomColorFactor());
    }

    /**
     * @return string
     */
    public static function randomRGBAColor(){
        return sprintf("rgba(%d,%d,%d,%s)",self::randomColorFactor(),self::randomColorFactor(),self::randomColorFactor(),(rand(0,100)/100));
    }

    /**
     * @param integer $number
     * @return array
     */
    public static function getRandomColors($number){
        $color = array();
        for($i= 0;$i<$number;$i++)
            $color[] = self::randomRGBColor();
        return $color;
    }

    /**
     * @param integer $number
     * @return array
     */
    public static function getRandomRGBAColors($number){
        $color = array();
        for($i= 0;$i<$number;$i++)
            $color[] = self::randomRGBAColor();
        return $color;
    }
} 
