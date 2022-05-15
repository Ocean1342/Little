<?php
require 'header.php';
?>
    <div class="message" style="margin-bottom: 20px">
        <?php if (isset($message) && $message != ''): ?>
            <p style=";padding: 5px;"><?= $message ?></p>
        <?php else: ?>
            <p>
                Page Not Found. Go <a href="/">homepage</a>
            </p>
        <?php endif; ?>
    </div>

<?php
require 'footer.php';