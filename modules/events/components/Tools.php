<?php

namespace app\modules\events\components;


use Yii;

class Tools
{

    /**
     * Обход проблемы создания одного и того же класса. При использование стандартного array_pad
     * @param $array
     * @param $count
     * @param $class
     * @return mixed
     */
    public static function array_pad($array, $count, $class)
    {
        if ($count == 0) {
            return $array;
        }
        $arrayCount = abs(count($array) - $count);
        for ($key = 0; $key < $arrayCount; $key++) {
            array_push($array, clone $class);
        }
        return $array;
    }

    /**
     * reset keys of array
     * @param $array
     * @param $key
     * @return mixed
     */
    public static function reset_keys_array($array,$key)
    {
        if (isset($array[$key])) {
            $array[$key] = array_values($array[$key]);
        }
        return $array;
    }

    /**
     * get allow users
     * @param array $add
     * @param array $delete
     * @return array
     */
    public static function getAllowUsers($add=[],$delete=[])
    {
        return array_diff(\yii\helpers\ArrayHelper::merge($add,array_keys(Yii::$app->getAuthManager()->getRoles())),$delete);
    }

}