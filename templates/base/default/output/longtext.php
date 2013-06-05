<?php
    echo nl2br(
            \home_io\templates\Template::parseUrls(
                    \home_io\templates\Template::getInstance()->sanitiseOutput($vars['value'])
            )
    ); 