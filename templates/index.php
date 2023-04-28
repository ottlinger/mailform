<!DOCTYPE HTML>
<!--
	Read Only by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<?php
require_once __DIR__.'/../vendor/autoload.php';

use mailform\FormHelper;
use mailform\Mailer;
use mailform\Message;

$hasErrors = false;
$isRobot = !(boolval(FormHelper::isSetAndNotEmptyInArray($_POST, 'mailform-priority')) && 'middle' === FormHelper::filterUserInput($_POST['mailform-priority']));
$sendOut = false;

?>
<html lang="en">
<head>
    <title>Mailform - example application</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>
    <link rel="stylesheet" href="assets/css/main.css"/>

    <link rel="icon" type="image/x-icon" href="assets/favicon/favicon.ico">
    <link rel="shortcut icon" href="assets/favicon/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="assets/favicon/house-152-237998.png">
    <meta name="msapplication-TileColor" content="#ffffff"/>
    <meta name="msapplication-TileImage" content="assets/favicon/house-144-237998.png">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="assets/favicon/house-152-237998.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/favicon/house-144-237998.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="assets/favicon/house-120-237998.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/favicon/house-114-237998.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/favicon/house-72-237998.png">
    <link rel="apple-touch-icon-precomposed" href="assets/favicon/house-57-237998.png">
    <link rel="icon" href="assets/favicon/house-32-237998.png" sizes="32x32">
</head>
<body class="is-preload">

<!-- Header -->
<section id="header">
    <header>
        <span class="image avatar"><img src="images/avatar.jpg" alt=""/></span>
        <h1 id="logo"><a href="#">Mailform</a></h1>
        <p>Send out mails</p>
    </header>
    <nav id="nav">
        <ul>
            <li><a href="#contact" class="active">Contact form</a></li>
        </ul>
    </nav>
    <footer>
        <ul class="icons">
		<?php
                    echo '<li><a target="_blank" href="'.Mailer::getFromConfiguration('pathimprint').'">imprint</a></li>';
                    echo '<li><a target="_blank" href="'.Mailer::getFromConfiguration('pathgdpr').'">data protection information (GDPR)</a></li><br /><br />';
        ?>
            <li>Feedback via <a href="https://www.github.com/ottlinger/mailform" target="_blank" class="icon fa-github"><span
                        class="label">Github</span> Github</a></li><br />
            <li><a href="https://aiki-it.de" target="_blank">Powered by AIKI IT</a></li>
        </ul>
    </footer>
</section>

<!-- Wrapper -->
<div id="wrapper">

    <!-- Main -->
    <div id="main">

        <!-- Contact form -->
        <section id="contact">
            <div class="container">
                <h3>Mailform example application</h3>
                <p>This mail form allows to send a message to a configured recipient address and the submitted mail
                    address. Apart from that there is a little
                    spam protection available.</p>
                <?php
                if (boolval(Mailer::getFromConfiguration('sendmails'))) {
                    echo '<h1 style="color:green;">Application is configured to really send out mails!</h1>';
                } else {
                    echo '<h1 style="color:lawngreen;">Application is running in demo-mode and will not send out mails.</h1>';
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $message = new Message($_POST['mailform-name'], $_POST['mailform-message'], $_POST['mailform-email']);
                    $mailer = new Mailer($message, true);

                    if (!$message->isValid() || $isRobot) {
                        echo '<h4 style="color:red;">There were errors while submitting the form, please provide all mandatory fields and a valid email.</h4>';
                        $hasErrors = true;
                    } else {
                        $sentWithoutErrors = $mailer->sendAllMails();
                        $sendOut = true;
                    }
                }

                if ($sendOut) {
                    if ($sentWithoutErrors) {
                        echo '<h4>Thanks for trying to submit your request at '.date('Y-m-d H:i:s').'</h4>';
                        echo '<div class="col-12"><p>Due to a technical error your message could not be sent out - please try again later. Sorry for the inconvenience.</p></div>';
                    } else {
                        echo '<h4>Thanks for submitting your request at '.date('Y-m-d H:i:s').'</h4>';
                    }
                    echo '<div class="col-12"><p>You may return to our >>> <a href="'.Mailer::getFromConfiguration('successlinktarget').'">main application page</a></p></div>';
                }
                ?>

                <?php
                if ($_SERVER['REQUEST_METHOD'] != 'POST' || $hasErrors) {
                    ?>
                <form method="post" action="#">
                    <?php
                } // end if not POST
                    ?>
                    <div class="row gtr-uniform">
                        <!-- TODO generify: all mailform-something ids are selected and put into the mail -->
                        <!--div class="col-12">
                            <label for="mailform-category">Please select the category of your request:</label>
                            <select name="mailform-category" id="mailform-category">
                                <option value="1">Contact request</option>
                                <option value="2">Book request</option>
                                <option value="3">Administration</option>
                            </select>
                        </div-->
                        <div class="col-6 col-12-xsmall">
                            <label for="mailform-name">Please provide your name:</label>
                            <input type="text" name="mailform-name" id="mailform-name"
                                <?php
                                if ($hasErrors || boolval(FormHelper::isSetAndNotEmptyInArray($_POST, 'mailform-name'))) {
                                    echo " value='".FormHelper::filterUserInput($_POST['mailform-name'])."' ";
                                    if ($message->hasNameErrors()) {
                                        echo ' style="border-color: red;" ';
                                    }
                                }
                                ?>
                                                                placeholder="Your name"/>
                        </div>
                        <div class="col-6 col-12-xsmall">
                            <label for="mailform-email">Please provide your email:</label>
                            <input type="email" name="mailform-email" id="mailform-email"
                                <?php
                                if ($hasErrors || boolval(FormHelper::isSetAndNotEmptyInArray($_POST, 'mailform-email'))) {
                                    echo " value='".FormHelper::filterUserInput($_POST['mailform-email'])."' ";
                                    if ($message->hasMailErrors()) {
                                        echo ' style="border-color: red;" ';
                                    }
                                }
                                ?>

                                                                placeholder="Your email"/></div>
                        <div class="col-12">
                            <label for="mailform-message">We are looking forward to your message:</label>
                            <textarea name="mailform-message" id="mailform-message" placeholder="Your message"
                                <?php
                                if (isset($message) && $message->hasContentsErrors()) {
                                    echo ' style="border-color: red;" ';
                                }
                                ?>
                                      rows="6"><?php
                                if ($hasErrors || boolval(FormHelper::isSetAndNotEmptyInArray($_POST, 'mailform-message'))) {
                                    echo FormHelper::filterUserInput($_POST['mailform-message']);
                                }
                                ?></textarea></div>

                        <?php
                        if (!$sendOut) {
                            ?>

                            <p
                                <?php
                                if ($isRobot && $_SERVER['REQUEST_METHOD'] === 'POST') {
                                    echo ' style="color: red;" ';
                                } ?>
                            >Please click the <strong>middle</strong> button, in order to proof that you are not a
                                robot:
                            </p>

                            <div class="col-4 col-12-medium">
                                <input type="radio" id="mailform-priority-low" name="mailform-priority" value="low"
                                    <?php
                                    if (boolval(FormHelper::isSetAndNotEmptyInArray($_POST, 'mailform-priority')) && 'low' === FormHelper::filterUserInput($_POST['mailform-priority'])) {
                                        echo ' checked';
                                    } ?>
                                >
                                <label for="mailform-priority-low">Left</label>
                            </div>
                            <div class="col-4 col-12-medium">
                                <input type="radio" id="mailform-priority-normal" name="mailform-priority"
                                       value="middle"
                                    <?php
                                    if (boolval(FormHelper::isSetAndNotEmptyInArray($_POST, 'mailform-priority')) && 'middle' === FormHelper::filterUserInput($_POST['mailform-priority'])) {
                                        echo ' checked';
                                    } ?>
                                >
                                <label for="mailform-priority-normal">Middle</label>
                            </div>
                            <div class="col-4 col-12-medium">
                                <input type="radio" id="mailform-priority-high" name="mailform-priority" value="high"
                                    <?php
                                    if (boolval(FormHelper::isSetAndNotEmptyInArray($_POST, 'mailform-priority')) && 'high' === FormHelper::filterUserInput($_POST['mailform-priority'])) {
                                        echo ' checked';
                                    } ?>
                                >
                                <label for="mailform-priority-high">Right</label>
                            </div>

                            <?php
                        } // end if DO NOT SHOW if sendOut

                        if ((!$hasErrors && $_SERVER['REQUEST_METHOD'] != 'POST') || $hasErrors) {
                            ?>
                            <div class="col-12">
                                <ul class="actions">
                                    <li><input type="submit" class="button primary" value="Send Message"/></li>
                                    <li><input type="reset" value="Reset Form"/></li>
                                </ul>
                            </div>
                            <?php
                        } // end if NOT-POST
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && boolval(Mailer::getFromConfiguration('debug'))) {
                            echo "<code class='col-12'>Data that was submitted: ";
                            var_dump($_POST);
                            echo '</code>';
                        }
                        ?>
                    </div>
                </form>
            </div>
        </section>

    </div>

    <!-- Footer -->
    <section id="footer">
        <div class="container">
            <ul class="copyright">
                <li>&copy; Mailform, 2020-<?php echo date('Y'); ?> All rights reserved.</li>
                <li>Template based on <a href="https://html5up.net">HTML5 UP ReadOnly</a></li>
                <li>Served by <a target="_blank" href="https://www.github.com/ottlinger/mailform">Mailform</a> from <a
                        target="_blank" href="https://aiki-it.de">AIKI IT</a></li>
            </ul>
        </div>
    </section>
</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
