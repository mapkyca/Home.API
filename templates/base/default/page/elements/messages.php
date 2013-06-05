<?php
$errors = Site::getSiteMessages('error');
$system = Site::getSiteMessages('system');
$success = Site::getSiteMessages('success');
$debug = Site::getSiteMessages('debug');
?>
<div class="messages">
    <?php
    if ($errors) {
        ?>
        <div class="messagelist errors">
            <ul>
                <?php
                foreach ($errors as $error)
                    echo \home_io\templates\Template::v('messages/error', array('message' => $error));
                ?>
            </ul>
        </div>
        <?php
    }

    if ($success) {
        ?>
        <div class="messagelist success">
            <ul>
                <?php
                foreach ($success as $message)
                    echo \home_io\templates\Template::v('messages/success', array('message' => $message));
                ?>
            </ul>
        </div>
        <?php
    }

    if ($system) {
        ?>
        <div class="messagelist system">
            <ul>
                <?php
                foreach ($system as $message)
                    echo \home_io\templates\Template::v('messages/system', array('message' => $message));
                ?>
            </ul>
        </div>
        <?php
    }

    if ($debug) {
        ?>
        <div class="messagelist debug">
            <ul>
                <?php
                foreach ($debug as $message)
                    echo \home_io\templates\Template::v('messages/debug', array('message' => $message));
                ?>
            </ul>
        </div>
        <?php
    }
    ?>
</div>
<script>
    $(document).ready(function() {
        $("div.messages div.messagelist").click(function(object) {
            $(this).fadeOut();
        });
      
        setTimeout(function() { $('div.messages div.system').fadeOut(); }, 5000);
    });
</script>