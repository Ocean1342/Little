<?php
require 'header.php';
?>

    <h1>Welcome to the Little!</h1>
    <div class="message" style="margin-bottom: 20px">


<!--        {% if message == false %}-->
        <? if (isset($message) && $message != ''): ?>
            <p style=";padding: 5px;"><?= $message ?></p>
        <? else: ?>
            <p>Enter your link:</p>
        <? endif; ?>
    </div>
    <form action="/" method="post">
        <label class="form-control" for="base_link">
            <input type="text" name="base_link" id="base_link" required
                   placeholder="E.g.https://google.com/">
        </label>
        <button type="submit">Send</button>
    </form>


<?php
require 'footer.php';