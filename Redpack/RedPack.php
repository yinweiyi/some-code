<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/23 0023
 * Time: 下午 5:27
 */

class RedPack
{

    /**
     * 抢红包算法
     *
     * @param $amount
     * @param $count
     * @return array
     */
    public function compute($amount, $count)
    {
        if ($count == 1) {
            return [$amount];
        }
        //计算平均数
        $avg = $amount / $count;

        $min = $avg * 0.5;

        $max = $avg * 1.5;

        $bonus = [];

        do {
            $bonus[] = floatval(sprintf("%01.2f", $this->randomFloat($min, $max)));
        } while (count($bonus) < $count);

        //计算总数和总数比例
        $scale = array_sum($bonus) / $amount;

        //根据比例重新计算每一个值
        $bonus = array_map(function ($item) use ($scale) {
            return floatval(sprintf("%01.2f", $item / $scale));
        }, $bonus);

        //随机抽取一个数字做最后精度处理
        $randomIndex = rand(0, count($bonus) - 1);
        $bonus[$randomIndex] = round($amount - (array_sum($bonus) - $bonus[$randomIndex]), 2);

        return $bonus;
    }

    /**
     * 随机小数
     *
     * @param int $min
     * @param int $max
     * @return float|int
     */
    public function randomFloat($min = 0, $max = 1)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}