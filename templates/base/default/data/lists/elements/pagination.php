<?php

    $limit = (int)Input::get('limit', $vars['limit']);
    if (!$limit) $limit = 10;
    $offset = (int)Input::get('offset', $vars['offset']);
    $total = $vars['total'];
    
    // Strip parameters
     $baseurl = Site::currentUrl(); //$_SERVER['REQUEST_URI'];
     $baseurl = preg_replace('/[\&\?]offset=[0-9]*/',"", $baseurl);
     
     if (($total > $limit) || ($offset > 0))
     {
?>
<div class="pagination">
    <ul>
	<?php 
	if ($offset > 0) {
	   
	    $prevurl = $baseurl;
	    $prevoffset = $offset - $limit;
	    if ($prevoffset < 0) $prevoffset = 0;
	    
	    if (substr_count($baseurl,'?')) 
		    $delim = '&';
	    else
		    $delim = '?';
	    $prevurl .= "{$delim}offset=$prevoffset";
	    
	    ?>
		    <li class="previous"><a href="<?php echo $prevurl; ?>">&laquo; <?php  i18n::w('pagination:previous'); ?></a></li>
	    <?php 
	    
	} 
	?>
	
	
	<?php
	
	
	if ($offset > 0 || $offset < ($total - $limit)) {
	    
	    $currentpage = round($offset / $limit) + 1;
	    $total_pages = ceil($total / $limit);
	    
	    
	    $i = 1;
	    $pagesarray = array();
	    while ($i <= $total_pages && $i <= 4) {
		    $pagesarray[] = $i;
		    $i++;
	    }
	    
	    $i = $currentpage - 2;
	    while ($i <= $total_pages && $i <= ($currentpage + 2)) {
		    if ($i > 0 && !in_array($i,$pagesarray))
			    $pagesarray[] = $i;
		    $i++;
	    }
	    
	    $i = $total_pages - 3;
	    while ($i <= $total_pages) {
		    if ($i > 0 && !in_array($i,$pagesarray))
			    $pagesarray[] = $i;
		    $i++;
	    }
	    
	    sort($pagesarray);
		
	    $prev = 0;
	    
	    // Simple pagination for now
	    foreach($pagesarray as $i) 
	    {
		    if (($i - $prev) > 1) {
			?>
		    <li class="pagination_more">...</li>
			<?php
		    }
	    
		    $pageurl = $baseurl;
		    $curoffset = (($i-1) * $limit);
		    if (substr_count($baseurl,'?')) 
			    $delim = '&';
		    else
			    $delim = '?';
		    
		    $pageurl .= "{$delim}offset=" . $curoffset;

		    ?>
		    <li<?php if ($curoffset==$offset) echo " class=\"active current\""; ?>><a href="<?php echo $pageurl; ?>"><?php echo ($i); ?></a></li>
		    <?php
		    
		    $prev = $i;
	    }
	    
	}
	?>
	
	
	<?php 
	if ($offset < ($total - $limit)) {
	    $nexturl = $baseurl;
	    $nextoffset = $offset + $limit;
	    if ($nextoffset >= $total) $nextoffset--;
	    
	    if (substr_count($baseurl,'?')) 
		    $delim = '&';
	    else
		    $delim = '?';
	    $nexturl .= "{$delim}offset=$nextoffset";
	    
	    ?>
		    <li class="next"><a href="<?php echo $nexturl; ?>"><?php i18n::w('pagination:next'); ?> &raquo;</a></li>
	    <?php 
	} 
	?>
    </ul>
</div>
<?php
     }