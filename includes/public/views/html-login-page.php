<?php
global $hax_wsba_config;
global $hax_wsba_login_page;

// One error pattern for now.
$error_message = $hax_wsba_login_page->errors->get_error_message('incorrect_user_or_pw');

$title   = get_option('hax_wsba_title');
$message = get_option('hax_wsba_message');
?>

<html>
    <head>
    <?php wp_head(); ?>
    </head>

<?php if($error_message) { ?>
    <body onload="fadeIn(document.getElementById('error'));">
<?php } else { ?>
    <body>
<?php } ?>

<div id="wsba">
    <div class="container">
        <div class="box">
            <!-- Title -->
            <h3><?php echo $title; ?></h3>

            <?php if($error_message) { ?>
                <!-- Error Message -->
                <div id="error" style="opacity: 0;">
                    <strong><?php echo $error_message; ?></strong>
                </div>
            <?php } ?>

            <!-- Message -->
            <p><?php echo $message; ?></p>

            <!-- Form -->
            <form action="wp-login.php" method="post">
                <ul>
                    <li>
                        <label for="user_name"><?php esc_html_e('User Name', 'wp-similar-basic-auth'); ?></label>
                        <input type="text" name="user_name">
                    </li>
                    <li>
                        <label for="password"><?php esc_html_e('Password', 'wp-similar-basic-auth'); ?></label>
                        <input type="password" name="password">
                    </li>
                </ul>
                <div>
                    <input type="submit" value="<?php esc_html_e('Log In', 'wp-similar-basic-auth'); ?>" class="submit">
                </div>
                <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( $hax_wsba_config->nonce_login_page ); ?>" />
            </form>

        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>