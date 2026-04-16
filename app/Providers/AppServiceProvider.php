<?php

namespace App\Providers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $allowedIPs = array_map('trim', explode(',', config('app.debug_allowed_ips', '')));

        $allowedIPs = array_filter($allowedIPs);

        if (empty($allowedIPs)) {
            return;
        }

        if (in_array(Request::ip(), $allowedIPs)) {
            Debugbar::enable();
        } else {
            Debugbar::disable();
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Usamos el evento 'after' porque aquí la orden ya tiene ID y existe en la DB
        Event::listen('checkout.order.save.after', function ($order) {
            // Los datos del request están disponibles aquí
            $bankData = [
                'bank_name' => request()->input('bank_name'),
                'bank_reference' => request()->input('bank_reference'),
                'bank_amount' => request()->input('bank_amount'),
            ];

            // Log de seguridad para que verifiques en storage/logs/laravel.log
            // \Log::info('Guardando datos bancarios para la orden '.$order->id, $bankData);

            // Si los datos existen en el request, actualizamos la tabla directamente
            // Esto se salta el $fillable y cualquier protección de modelo
            if ($bankData['bank_name'] || $bankData['bank_reference']) {
                DB::table('orders')
                    ->where('id', $order->id)
                    ->update($bankData);
            }
        });

        // Tu código existente de ParallelTesting
        ParallelTesting::setUpTestDatabase(function (string $database, int $token) {
            Artisan::call('db:seed');
        });
    }
}
