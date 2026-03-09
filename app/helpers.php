<?php


if (! function_exists('modelLabel')) {
    function modelLabel($model)
    {
        $name = class_basename($model);
        return __("models.$name");
    }
}

if (! function_exists('columnLabel')) {
    function columnLabel($column)
    {
        return __("columns.$column");
    }
}