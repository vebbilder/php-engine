<?php
if (!is_admin()) {
    redirect(SITE_URL . '/login');
}

global $pdo;

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

switch ($action) {
    case 'list':
        $stmt = $pdo->query("SELECT * FROM pages ORDER BY created_at DESC");
        $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $content = "
        <h2>Manage Pages</h2>
        <a href='" . SITE_URL . "/admin/pages?action=add'>Add New Page</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>";

        foreach ($pages as $page) {
            $content .= "
            <tr>
                <td>{$page['id']}</td>
                <td>{$page['title']}</td>
                <td>{$page['slug']}</td>
                <td>
                    <a href='" . SITE_URL . "/admin/pages?action=edit&id={$page['id']}'>Edit</a>
                    <a href='" . SITE_URL . "/admin/pages?action=delete&id={$page['id']}' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                </td>
            </tr>";
        }

        $content .= "</table>";
        break;

    case 'add':
    case 'edit':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $page = $id ? $pdo->query("SELECT * FROM pages WHERE id = $id")->fetch(PDO::FETCH_ASSOC) : [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = sanitize_input($_POST['title']);
            $slug = sanitize_input($_POST['slug']);
            $content = $_POST['content']; // Allow HTML content
            $template = sanitize_input($_POST['template']);

            if ($action == 'add') {
                $stmt = $pdo->prepare("INSERT INTO pages (title, slug, content, template) VALUES (?, ?, ?, ?)");
                $stmt->execute([$title, $slug, $content, $template]);
            } else {
                $stmt = $pdo->prepare("UPDATE pages SET title = ?, slug = ?, content = ?, template = ? WHERE id = ?");
                $stmt->execute([$title, $slug, $content, $template, $id]);
            }

            redirect(SITE_URL . '/admin/pages');
        }

        $content = "
        <h2>" . ($action == 'add' ? 'Add New' : 'Edit') . " Page</h2>
        <form method='post'>
            <label for='title'>Title:</label>
            <input type='text' id='title' name='title' value='" . ($page['title'] ?? '') . "' required>

            <label for='slug'>Slug:</label>
            <input type='text' id='slug' name='slug' value='" . ($page['slug'] ?? '') . "' required>

            <label for='content'>Content:</label>
            <textarea id='content' name='content' rows='10' required>" . ($page['content'] ?? '') . "</textarea>

            <label for='template'>Template:</label>
            <input type='text' id='template' name='template' value='" . ($page['template'] ?? 'default') . "' required>

            <button type='submit'>" . ($action == 'add' ? 'Add' : 'Update') . " Page</button>
        </form>";
        break;

    case 'delete':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id) {
            $pdo->exec("DELETE FROM pages WHERE id = $id");
        }
        redirect(SITE_URL . '/admin/pages');
        break;
}

$title = "Manage Pages";
require "admin/admin_template.php";
?>