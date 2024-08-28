<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />
        <div x-data="{
                dynamicKey: @js(auth()->user()->dynamic_key_id ?? '-1'),
                localStorageKey: 'dynamic_key_id',
                isValidKey: false,
                init() {
                    const localStorageKey = localStorage.getItem(this.localStorageKey);
                    this.isValidKey = localStorageKey === this.dynamicKey;
                    if (this.isValidKey){
                        Livewire.dispatch('dynamicKeyActivated');
                        console.log('activate');
                    }
                }
            }" x-init="init">
            <div class="min-h-screen bg-gray-100">
                @livewire('navigation-menu')

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto sm:py-6 py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
                <livewire:modals.time-out-modal />
            </div>
        </div>
        @stack('modals')
        @stack('scripts')
        @livewireScripts
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function notifyRouteChange() {
                    Livewire.dispatch('route-changed', { url: window.location.href });
                }
                window.addEventListener('popstate', notifyRouteChange);

                document.body.addEventListener('click', function (e) {
                    var target = e.target.closest('a');
                    if (target && target.href && target.href.startsWith(window.location.origin)) {
                        window.history.pushState({}, '', target.href);
                        notifyRouteChange();
                    }
                });
                notifyRouteChange();

                Livewire.on('dynamic-key-activated', event => {
                    const uuid = event[0];
                    if (uuid) {
                        localStorage.setItem('dynamic_key_id', uuid);
                    } else {
                        console.error('UUID is undefined');
                    }
                });
            });
        </script>
    </body>
</html>
