<?php 
    echo json_encode(array(
        'class' => get_class($vars['exception']),
        'details' => $vars['exception']->getMessage()
            ));
