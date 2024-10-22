<?php
if (!is_admin()) {
    redirect(SITE_URL . '/login');
}

$title = "Admin Dashboard";
$content = "
<h2>Welcome to the Admin Dashboard</h2>
<ul>
    <li><a href='" . SITE_URL . "/admin/pages'>Manage Pages</a></li>
    <li><a href='" . SITE_URL . "/admin/users'>Manage Users</a></li>
</ul>
";

require "admin/admin_template.php";
?>