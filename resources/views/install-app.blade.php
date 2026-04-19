<x-shop::layouts>
    <x-slot:title>Instalar APP | {{ config('app.name') }}</x-slot:title>

    @push('styles')
        <style>
            :root {
                --pink-logo: {{ config('app.color_pink_logo') }};
                --blue-dark: {{ config('app.color_blue_dark') }};
            }
            .pink-brand-text { color: var(--pink-logo) !important; }
            .blue-brand-text { color: var(--blue-dark) !important; }

            /* Contenedor principal centrado y con margen lateral */
            .pwa-main-container {
                max-width: 900px !important;
                margin: 20px auto !important; /* Separación del header de la tienda */
                background: #fff;
                border: 1px solid #eee;
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            }

            /* Forzamos que el QR y las letras no se peguen a la línea gris */
            .pwa-content-wrapper {
                display: flex;
                flex-wrap: wrap;
                padding: 60px 40px !important; /* Mucho padding interno */
                gap: 50px;
                align-items: flex-start;
            }

            .qr-section {
                flex: 1;
                min-width: 300px;
                text-align: center;
            }

            .qr-boutique-box {
                border: 4px solid var(--blue-dark) !important;
                box-shadow: 12px 12px 0px 0px rgba(166, 10, 106, 0.15) !important;
                padding: 20px;
                display: inline-block;
                margin-bottom: 20px;
            }

            .instructions-section {
                flex: 1.5;
                min-width: 300px;
            }

            .step-card {
                border-left: 4px solid var(--pink-logo);
                padding-left: 20px;
                margin-bottom: 40px;
                text-align: justify;
            }

            .btn-pink-outline {
                border: 2px solid var(--pink-logo) !important;
                color: var(--pink-logo) !important;
                font-weight: 900;
                padding: 12px 45px;
                text-decoration: none;
                display: inline-block;
                transition: 0.3s;
            }
            .btn-pink-outline:hover {
                background: var(--pink-logo) !important;
                color: #fff !important;
            }
        </style>
    @endpush

    <div class="pwa-main-container">
        {{-- Header --}}
        <div style="padding: 40px; text-align: center; border-bottom: 1px solid #eee;">
            <h1 style="font-size: 32px; text-transform: uppercase; letter-spacing: normal !important; margin: 0; display: block !important;">
                {{--<span class="pink-brand-text" style="font-weight: 900; margin-right: 8px !important;">Pink</span>
                <span class="blue-brand-text" style="font-weight: 700;">Shop's</span>--}}
                @php
                    $appName = config('app.name', 'Pink Shop\'s');
                    $parts = explode(' ', $appName, 2); // Dividimos en máximo 2 partes
                @endphp


                {{-- Primera palabra (siempre existe) --}}
                <span class="pink-brand-text" style="font-weight: 900; margin-right: 8px !important;">
                    {{ $parts[0] }}
                </span>

                {{-- Segunda palabra (solo si existe en el APP_NAME) --}}
                @if(isset($parts[1]))
                    <span class="blue-brand-text" style="font-weight: 700;">
                    {{ $parts[1] }}
                    </span>
                @endif

            </h1>
            <div style="margin-top: 15px; font-size: 11px; font-weight: bold; color: #999; letter-spacing: 3px; text-transform: uppercase;">
                @foreach($categories as $category)
                    {{-- Nombre de la categoría --}}
                    <span>
                        {{ $category->name }}
                    </span>

                    {{-- Solo mostramos el punto si NO es el último elemento --}}
                    @if (!$loop->last)
                        <span class="pink-brand-text opacity-60">•</span>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Contenido con Flexbox forzado --}}
        <div class="pwa-content-wrapper">

            {{-- QR --}}
            <div class="qr-section">
                <div class="qr-boutique-box">
                    <img src="{{ $qrIos }}"
                         style="width: 240px; height: 240px; display: block;" alt="QR link de {{ config('app.name') }}">
                </div>
                <p style="font-size: 10px; font-weight: 900; color: #bbb; letter-spacing: 2px; text-transform: uppercase; margin-top: 10px;">
                    Escanea para instalar
                </p>
            </div>

            {{-- Pasos --}}

            <div class="instructions-section" style="max-width: 100%; overflow: hidden;">
                <h2 style="color: #0a016d; font-size: 18px; font-weight: 900; text-transform: uppercase; margin-bottom: 30px;">
                    Guía de instalación
                </h2>

                {{-- Paso 01 --}}
                <div class="step-card" style="border-left: 4px solid var(--pink-logo); padding-left: 20px; margin-bottom: 40px;">
                    <div style="color: var(--pink-logo); font-weight: 900; font-size: 24px;">01.</div>
                    <h3 style="color: #0a016d; font-size: 13px; font-weight: 900; text-transform: uppercase; margin: 5px 0; display: flex; align-items: center; flex-wrap: wrap; gap: 5px;">
                        Android (Chrome)
                        {{--<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #666;"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><line x1="21.17" y1="8" x2="12" y2="8"></line><line x1="3.95" y1="6.06" x2="8.54" y2="14"></line><line x1="10.88" y1="21.94" x2="15.46" y2="14"></line></svg>--}}
                    </h3>
                    <p style="color: #666; font-size: 14px; line-height: 1.6; margin: 0; text-align: justify; white-space: normal;">
                        Abre <b>Chrome</b>, toca el icono de los
                        <span style="display: inline-flex; align-items: center; vertical-align: middle; background: #eee; padding: 2px; border-radius: 4px; margin: 0 5px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
            </span>
                        <b>tres puntos</b> y selecciona <span style="color: var(--pink-logo); font-weight: bold; text-decoration: underline;">"Instalar aplicación"</span>.
                    </p>
                </div>

                {{-- Paso 02 --}}
                <div class="step-card" style="border-left: 4px solid var(--pink-logo); padding-left: 20px; margin-bottom: 40px;">
                    <div style="color: var(--pink-logo); font-weight: 900; font-size: 24px;">02.</div>
                    <h3 style="color: #0a016d; font-size: 13px; font-weight: 900; text-transform: uppercase; margin: 5px 0; display: flex; align-items: center; flex-wrap: wrap; gap: 5px;">
                        iPhone (Safari)
                        {{--<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #666;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>--}}
                    </h3>
                    <p style="color: #666; font-size: 14px; line-height: 1.6; margin: 0; text-align: justify; white-space: normal;">
                        En <b>Safari</b>, toca el botón de
                        <span style="display: inline-flex; align-items: center; vertical-align: middle; background: #e0f2fe; color: #0284c7; padding: 3px; border-radius: 4px; margin: 0 5px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg>
            </span>
                        <b>Compartir</b> y selecciona <span style="color: var(--pink-logo); font-weight: bold; text-decoration: underline;">"Agregar a inicio"</span>.
                    </p>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div style="padding: 40px; text-align: center; border-top: 1px solid #eee; background: #fafafa;">
            <a href="{{ url('/') }}" class="btn-pink-outline">Volver al inicio</a>
        </div>
    </div>
</x-shop::layouts>
