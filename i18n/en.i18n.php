<?php

namespace home_io\i18n {

    $errors = array(
        // System
        'exception:title' => 'Exception',
        // Pages
        'page:exception:notfound' => 'Page \'%s\' not found.',
        // API
        'api:exception:class_not_specified' => 'Endpoint definition "%s" has no class entry defined!',
        'api:exception:class_not_found' => 'Class "%s" could not be found.',
        'api:exception:api_not_found' => 'The requested API (\'%s\') was not found on this server, please check your definition file.',
        'api:exception:no_constructor' => 'I don\'t know how to create "%s" as the class has no constructor',
        'api:exception:missing_construction_parameter' => 'Missing parameter "%s" missing in class %s\'s constructor',
        'api:exception:could_not_create_instance' => 'Could not create new instance of class "%s"',
        'api:exception:no_method' => 'No method call given, use the format like http://server.com/api/path/to/endpoint/methodcall.json',
        'api:exception:method_not_found' => 'Method %s::%s could not be found',
        'api:exception:missing_method_parameter' => 'Missing parameter "%s" missing in method "%s"',
    );

    Basic::register($errors, 'en');
}