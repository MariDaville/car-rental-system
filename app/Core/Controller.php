<?php

namespace App\Core;

class Controller
{
    /**
     * Load and render a view.
     *
     * @param string $view
     * @param array $data
     */
    protected function render(string $view, array $data = []): void
    {
        $viewPath = BASE_PATH . '/resources/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new \RuntimeException(
                "View not found: {$view}"
            );
        }

        // Make data available to the view
        extract($data, EXTR_SKIP);

        // Render the view
        require $viewPath;
    }

    /**
     * Redirect to another URL.
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}