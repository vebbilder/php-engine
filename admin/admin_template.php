<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Admin Panel</title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="<?php echo SITE_URL; ?>/admin">Dashboard</a></li>
                <li><a href="<?php echo SITE_URL; ?>/admin/pages">Pages</a></li>
                <li><a href="<?php echo SITE_URL; ?>/admin/users">Users</a></li>
                <li><a href="<?php echo SITE_URL; ?>">View Site</a></li>
                <li><a href="<?php echo SITE_URL; ?>/logout">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php echo $content; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Your CMS Admin Panel</p>
    </footer>

    <script src="<?php echo SITE_URL; ?>/assets/js/admin.js"></script>
</body>
</html>