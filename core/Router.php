<?php
class Router {
    public function route() {
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if (empty($url[0])) {
            require 'pages/home.php';
            return;
        }

        if ($url[0] == 'admin') {
            if (!is_admin()) {
                redirect(SITE_URL . '/login');
            }
            array_shift($url);
            $this->handleAdmin($url);
            return;
        }

        $page = $this->getPage($url[0]);
        if ($page) {
            extract($page);
            require "templates/{$template}.php";
        } else {
            require 'pages/404.php';
        }
    }

    private function handleAdmin($url) {
        if (empty($url[0])) {
            require 'admin/dashboard.php';
            return;
        }

        $file = 'admin/' . $url[0] . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            require 'admin/404.php';
        }
    }

    private function getPage($slug) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>