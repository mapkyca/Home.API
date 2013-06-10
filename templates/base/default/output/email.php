<?php

    $href = filter_var($vars['value'],FILTER_SANITIZE_EMAIL);
    if ($vars['label']) $vars['value'] = $vars['label'];
    
?>
<a href="mailto:<?php echo $href; ?>"><?php echo \home_api\templates\Template::v('output/text', $vars); ?></a>