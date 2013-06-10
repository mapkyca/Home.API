<?php

    $href = filter_var($vars['value'],FILTER_SANITIZE_URL);
    if ($vars['label']) $vars['value'] = $vars['label'];
    
?>
<a href="<?php echo $href; ?>"><?php echo \home_api\templates\Template::v('output/text', $vars); ?></a>