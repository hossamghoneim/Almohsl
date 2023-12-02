<?php
  
namespace App\Enums;
 
enum ColorsEnum:string 
{
    case Black = '#000000';
    case ForestGreen = '#008000';
    case DarkGray = '#333333';
    case LightGray = '#CCCCCC';
    case NavyBlue = '#001F3F';
    case RoyalBlue = '#0074CC';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}