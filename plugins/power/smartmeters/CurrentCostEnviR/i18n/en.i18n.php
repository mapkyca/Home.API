<?php

namespace power\smartmeters {

    $en = array(
        'currentcostenvir:exception:time_unavailable' => 'Time currently not available.',
        'currentcostenvir:exception:temp_unavailable' => 'Temperature currently not available.',
        'currentcostenvir:exception:power_unavailable' => 'Power not currently available.',
        
        'currentcostenvir:exception:cant_open_device' => "Can't open device (%s:%d), please make sure that the port is readable by your web server user.",
        
        'currentcostenvir:time' => 'Time',
        'currentcostenvir:temp' => 'Temperature',
        'currentcostenvir:temp:reading' => '%s C',
        'currentcostenvir:power' => 'Reading',
        'currentcostenvir:power:reading' => '%s watts',
    );

    \home_api\i18n\Basic::register($en, 'en');
}