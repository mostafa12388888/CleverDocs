<?php
namespace App\Enum\Dashboard;

use App\Enum\Enum;

class ChartTypeEnum extends Enum
{
    const LINE = 'line';
    const BAR = 'bar';
    const PIE = 'pie';
    const DOUGHNUT = 'doughnut';
    const RADAR = 'radar';
    const POLAR_AREA = 'polarArea';
    const BUBBLE = 'bubble';
    const SCATTER = 'scatter';
    const HORIZONTAL_BAR = 'horizontalBar';
}
