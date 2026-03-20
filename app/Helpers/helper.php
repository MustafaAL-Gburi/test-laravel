<?php

namespace App\Helpers;

class helper
{
    public static function can($permission)
    {
        return true; // مؤقتًا كل شيء مسموح
    }

    public static function cant($permission)
    {
        return false; // مؤقتًا لا يوجد منع
    }
}
