<?php
    echo nl2br(
            \home_api\templates\Template::parseUrls(
                    \home_api\templates\Template::getInstance()->sanitiseOutput($vars['value'])
            )
    ); 