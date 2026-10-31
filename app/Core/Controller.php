<?php

namespace App\Core;

class Controller
{
    /**
     * Render a view inside a shared layout.
     */
    protected function render(
        string $view,
        array $data = [],
        string $layout = 'main'
    ): void {

        $viewPath = BASE_PATH . '/resources/views/' . $view . '.php';

        $layoutPath = BASE_PATH . '/resources/views/layouts/' . $layout . '.php';

        // Verify that the requested view exists
        if (!file_exists($viewPath)) {
            throw new \RuntimeException(
                "View not found: {$view}"
            );
        }

        // Verify that the requested layout exists
        if (!file_exists($layoutPath)) {
            throw new \RuntimeException(
                "Layout not found: {$layout}"
            );
        }

        // Make supplied data available to the view and layout
        extract($data, EXTR_SKIP);

        // Capture the page-specific view output
        ob_start();

        require $viewPath;

        $content = ob_get_clean();

        // Render the shared layout around the page content
        require $layoutPath;
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