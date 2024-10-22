<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="<?php echo SITE_URL; ?>">Home</a></li>
                <?php if (is_logged_in()): ?>
                    <li><a href="<?php echo SITE_URL; ?>/profile">Profile</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo SITE_URL; ?>/login">Login</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h1><?php echo $title; ?></h1>
        <?php echo $content; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Your Website</p>
    </footer>

    <script src="<?php echo SITE_URL; ?>/assets/js/script.js"></script>
</body>
</html>