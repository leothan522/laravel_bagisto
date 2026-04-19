<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Webkul\Category\Repositories\CategoryRepository;

Route::get('/manifest.json', action: function () {
    $appName = config('app.name');
    $themeColor = config('app.color_pink_logo');
    $backgroundColor = config('app.manifest_background_color');
    $assetFavicons = config('app.manifest_asset_favicons');
    $icon192 = asset('favicons/icon-192x192.png');
    $icon192maskable = asset('favicons/icon-192x192-maskable.png');
    $icon512 = asset('favicons/icon-512x512.png');
    $icon512maskable = asset('icon-512x512-maskable.png');
    if (! empty($assetFavicons)) {
        if (File::exists('favicons/'.$assetFavicons.'/icon-192x192.png')) {
            $icon192 = asset('favicons/'.$assetFavicons.'/icon-192x192.png');
        }
        if (File::exists('favicons/'.$assetFavicons.'/icon-192x192-maskable.png')) {
            $icon192maskable = asset('favicons/'.$assetFavicons.'/icon-192x192-maskable.png');
        }
        if (File::exists('favicons/'.$assetFavicons.'/icon-512x512.png')) {
            $icon512 = asset('favicons/'.$assetFavicons.'/icon-512x512.png');
        }
        if (File::exists('favicons/'.$assetFavicons.'/icon-512x512-maskable.png')) {
            $icon512maskable = asset('favicons/'.$assetFavicons.'/icon-512x512-maskable.png');
        }
    }

    return response()->json([
        'name' => $appName,
        'short_name' => $appName,
        'description' => 'Tienda en Línea de '.$appName,
        'icons' => [
            [
                'src' => $icon192,
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'src' => $icon192maskable,
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'maskable',
            ],
            [
                'src' => $icon512,
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'src' => $icon512maskable,
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'maskable',
            ],
        ],
        'theme_color' => $themeColor,
        'background_color' => $backgroundColor,
        'display' => 'standalone',
        'scope' => './',
        'start_url' => './',
        'orientation' => 'portrait-primary',
        'lang' => 'es',
    ], 200, [
        'Content-Type' => 'application/json',
        'Charset' => 'utf-8',
    ]);
});

Route::get('/service-worker.js', function () {
    // Generamos el slug del nombre, con un fallback por seguridad
    $appName = config('app.name', 'pink-shop');
    $cacheName = Str::slug($appName);

    // Lógica dinámica para el archivo offline
    $assetFavicons = config('app.manifest_asset_favicons');
    $offlinePath = 'favicons/offline.html'; // Path por defecto

    if (! empty($assetFavicons)) {
        $customPath = 'favicons/'.$assetFavicons.'/offline.html';
        if (File::exists(public_path($customPath))) {
            $offlinePath = $customPath;
        }
    }

    $offlineURL = asset($offlinePath);

    $content = "
const CACHE_NAME = '{$cacheName}-cache-v1';
const OFFLINE_URL = '{$offlineURL}';

const PRECACHE_URLS = [
    OFFLINE_URL
];

// Precaching en instalacion
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(PRECACHE_URLS))
            .then(() => self.skipWaiting())
    );
});

// Activacion y limpieza de caches antiguos
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys.map(key => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            )
        ).then(() => self.clients.claim())
    );
});

// Intercepta peticiones: Intenta red, si falla busca en cache, si no hay cache y es navegacion, muestra offline
self.addEventListener('fetch', event => {
    if (event.request.method !== 'GET' || !event.request.url.startsWith('http')) return;

    event.respondWith(
        fetch(event.request).catch(() => {
            return caches.match(event.request).then(response => {
                if (response) {
                    return response;
                }

                // Si falla la red y no esta en cache, y es una navegacion (pagina), mostramos el offline.html
                if (event.request.mode === 'navigate') {
                    return caches.match(OFFLINE_URL);
                }
            });
        })
    );
});
    ";

    return response($content)->header('Content-Type', 'application/javascript');
});

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
