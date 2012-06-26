<h2>PayPal $_POST Vars</h2>
<dl>
    <?php
        
        foreach ($_POST as $k => $v) {
            echo "<dt>$k</dt>";
            echo "<dd>$k</dd>";
        }

    ?>
</dl>
