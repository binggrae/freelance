<?php


namespace core\helpers;


class CategoryHelper
{

    const STATUS_NEW = 0;
    const STATUS_WAIT = 5;
    const STATUS_PROGRESS = 10;
    const STATUS_ERROR = 15;
    const STATUS_COMPLETE = 20;

    public static function getStatusLabel($status = null)
    {
        $labels = [
            self::STATUS_NEW => 'Новая',
            self::STATUS_WAIT => 'Ожидает запуска',
            self::STATUS_PROGRESS => 'В работе',
            self::STATUS_ERROR => 'Ошибка',
            self::STATUS_COMPLETE => 'Завершено',
        ];

        return is_null($status) ? $labels : $labels[$status];
    }


    public static function getStatusClass($status)
    {
        $classes = [
            self::STATUS_NEW => 'label-default',
            self::STATUS_WAIT => 'label-warning',
            self::STATUS_PROGRESS => 'label-primary',
            self::STATUS_ERROR => 'label-danger',
            self::STATUS_COMPLETE => 'label-success',
        ];

        return $classes[$status];
    }

    public static function isDisabled($status)
    {
        return in_array($status, [
            self::STATUS_WAIT,
            self::STATUS_PROGRESS,
        ]);
    }


}