<div x-data="{ show: @entangle('show') }"
     x-on:close.stop="show = false"
     x-on:keydown.escape.window="show = false"
     x-show="show"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
     style="display: none;">
    <div class="fixed inset-0 transform transition-all" x-on:click="show = false" x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
         x-trap.noscroll.inert="show"
         x-on:click.away="$wire.handleModalClosed()">
        <!-- Contenido del modal -->
        <div class="px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">
                Session Timeout
            </h3>
            <p class="mt-2 text-sm text-gray-600">
                Your session has expired after 5 minutes. For security reasons, you will be redirected to the dashboard.
            </p>
        </div>
        <div class="px-6 py-4 bg-gray-100 text-right">
            <x-button wire:click="closeModal" class="px-4 py-2">
                OK
            </x-button>
        </div>
    </div>
</div>
