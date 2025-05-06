<?php

function route($page)
{
    $page = htmlspecialchars($page, ENT_QUOTES, 'UTF-8');

    // Đường dẫn cơ sở (từ router.php lên 2 cấp)
    $basePath = '../../';

    $routes = [
        'product-details' => $basePath . 'Components/Products/ProductDetails.php',
        'home' => [
            $basePath . 'Components/Banner/Banner.php',
            $basePath . 'Components/Products/Products.php',
            $basePath . 'Components/Feature/Feature.php'
        ]
    ];

    $footerPath = '../../../views/layout/includes/Footer.php';

    switch ($page) {
        case 'product-details':
            if (file_exists($routes['product-details'])) {
                include $routes['product-details'];
                if (file_exists($footerPath)) {
                    include $footerPath;
                } else {
                    echo "File Footer.php không tồn tại!";
                }
            } else {
                echo "File ProductDetails.php không tồn tại!";
            }
            break;

        case 'home':
        default:
            foreach ($routes['home'] as $file) {
                if (file_exists($file)) {
                    include $file;
                } else {
                    echo "File " . basename($file) . " không tồn tại!";
                }
            }
            if (file_exists($footerPath)) {
                include $footerPath;
            } else {
                echo "File Footer.php không tồn tại!";
            }
            break;
    }
}