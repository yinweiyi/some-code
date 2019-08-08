<?php


class Sort
{

    /**
     * 冒泡排序
     *
     * @param $array
     * @return mixed
     */
    public function bubble($array)
    {
        $len = count($array);

        for ($i = 0; $i < $len; $i++) {
            $flag = false;
            for ($j = 0; $j < $len - $i - 1; $j++) {
                if ($array[$j] > $array[$j + 1]) {
                    $tmp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array [$j + 1] = $tmp;
                    $flag = true;
                }
            }

            if (!$flag) break;
        }

        return $array;
    }

    /**
     * 插入排序
     *
     * @param $array
     * @return mixed
     */
    public function insertion($array)
    {
        $len = count($array);

        for ($i = 1; $i < $len; $i++) {
            $value = $array[$i];
            for ($j = $i - 1; $j >= 0; $j--) {
                if ($value < $array[$j]) {
                    $array[$j + 1] = $array[$j];
                } else {
                    break;
                }
            }
            $array[$j + 1] = $value;
        }

        return $array;
    }

    /**
     * 选择排序
     *
     * @param $array
     * @return mixed
     */
    public function selection($array)
    {
        $len = count($array);
        for ($i = 0; $i < $len; $i++) {
            $index = $i;
            for ($j = $i + 1; $j < $len; $j++) {
                if ($array[$index] > $array[$j]) {
                    $index = $j;
                }
            }
            if ($index !== $i) {
                $value = $array[$i];
                $array[$i] = $array[$index];
                $array[$index] = $value;
            }
        }

        return $array;
    }
}

$sort = new Sort();

$array = [6, 5, 4, 3, 2, 1, 0];

var_dump($sort->selection($array));
