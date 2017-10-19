<?php
/**
 * Created by PhpStorm.
 * User: unadm
 * Date: 19.10.17
 * Time: 14:33
 */

namespace app\components\behaviors;

use yii\behaviors\TimestampBehavior;

class DateBehavior extends TimestampBehavior
{
    /**
     * @inheritdoc
     *
     * In case, when the [[value]] is `null`, the result of the PHP function [date()](http://php.net/manual/en/function.date.php) as MySQL format
     * will be used as value.
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            return date('Y-m-d H:i:s', time());
        }
        return parent::getValue($event);
    }

}