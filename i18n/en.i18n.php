<?php

namespace home_io\i18n {

    $errors = array(
        // System
        'exception:title' => 'Exception',
        // Pages
        'page:exception:notfound' => 'Page \'%s\' not found.',
        // API
        'api:exception:class_not_specified' => 'Endpoint definition %s has no class entry defined!',
        'api:exception:class_not_found' => 'Class %s could not be found.'
    );

    Basic::register($errors, 'en');
}