<?php

use Illuminate\Support\Facades\Route;
use Webkul\Category\Repositories\CategoryRepository;

Route::get('/instalar-app', function () {
    $qrIos = qrCodeGenerate(\url('/'), 80, null, 'qr-ios-download');

    // Obtenemos el repositorio desde el contenedor de servicios
    $categoryRepository = app(CategoryRepository::class);

    // Traemos el árbol de categorías visibles vinculadas al canal actual
    $categories = $categoryRepository->getVisibleCategoryTree(
        core()->getCurrentChannel()->root_category_id
    );

    return view('install-app')
        ->with('qrIos', $qrIos)
        ->with('categories', $categories);
})->name('pwa.install');
