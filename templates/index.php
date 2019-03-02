<!DOCTYPE HTML>
<!--
	Read Only by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<?php
require_once __DIR__ . '/../vendor/autoload.php';

?>
<html lang="en">
<head>
    <title>Mailform - example application</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
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
            <li>Feedback via <a href="https://www.github.com/ottlinger/mailform" target="_blank" class="icon fa-github"><span
                            class="label">Github</span></a></li>
            <li><a href="https://aiki-it.de" target="_blank">AIKI IT</a></li>
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
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    print "<h3>SUBMIT - Contact Me with the help of Mailform</h3>";
                    print "<h4>Hello " . htmlspecialchars($_POST['mailform-name']) . "!</h4>";
                } else {
                    print "<h3>Mailform example application</h3>";
                }
                ?>
                <p>This mail form allows to send a message and select a request type. Apart from that there is a littels
                    spam protection available.</p>
                <form method="post" action="#">
                    <div class="row gtr-uniform">
                        <div class="col-12">
                            <label for="mailform-category">Please select the category of your request:</label>
                            <select name="mailform-category" id="mailform-category">
                                <option value="1">Contact request</option>
                                <option value="2">Book request</option>
                                <option value="3">Administration</option>
                            </select>
                        </div>
                        <div class="col-6 col-12-xsmall"><input type="text" name="mailform-name" id="mailform-name"
                                                                placeholder="Your name"/>
                        </div>
                        <div class="col-6 col-12-xsmall"><input type="email" name="mailform-email" id="mailform-email"
                                                                placeholder="Your email"/></div>
                        <div class="col-12">
                            <label for="mailform-message">We are looking forward to your message:</label>
                            <textarea name="mailform-message" id="mailform-message" placeholder="Your message"
                                      rows="6"></textarea></div>

                        <p>Please click the middle button, in order to proof that you are not a robot:</p>
                        <!-- Issue #4: checked and grouping of input to determine if middle is hit -->
                        <div class="col-4 col-12-medium">
                            <input type="radio" id="mailform-priority-low" name="mailform-priority">
                            <label for="mailform-priority-low">Left</label>
                        </div>
                        <div class="col-4 col-12-medium">
                            <input type="radio" id="mailform-priority-normal" name="mailform-priority">
                            <label for="mailform-priority-normal">Middle</label>
                        </div>
                        <div class="col-4 col-12-medium">
                            <input type="radio" id="mailform-priority-high" name="mailform-priority">
                            <label for="mailform-priority-high">Right</label>
                        </div>

                        <div class="col-12">
                            <ul class="actions">
                                <li><input type="submit" class="button primary" value="Send Message"/></li>
                                <li><input type="reset" value="Reset Form"/></li>
                            </ul>
                        </div>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            print "<code class='col-12'>You submitted: ";
                            var_dump($_POST);
                            print "</code>";
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
                <li>&copy; Mailform, <?php print date("Y-m-d"); ?> All rights reserved.</li>
                <li>Design: <a href="https://html5up.net">HTML5 UP</a></li>
                <li>Served by <a href="https://www.github.com/ottlinger/mailform">Mailform</a> from <a
                            href="https://aiki-it.de">AIKI IT</a></li>
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
