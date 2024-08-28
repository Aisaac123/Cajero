<div>
    <div x-data="{
                dynamicKey: @js(auth()->user()->dynamic_key_id ?? '-1'),
                localStorageKey: 'dynamic_key_id',
                isValidKey: false,
                init() {
                    const localStorageKey = localStorage.getItem(this.localStorageKey);
                    this.isValidKey = localStorageKey === this.dynamicKey;
                }
            }"
         x-init="init">
    <x-action-section>
        <x-slot name="title">
            {{ __('Dynamic Key Enabling') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Activate a dynamic key on this device for enhanced security transactions.') }}
        </x-slot>

        <x-slot name="content">
            <h3 class="text-lg font-medium text-gray-900">
                {{ __('Dynamic Key Enabling') }}
            </h3>
            <div class="max-w-xl text-sm text-gray-600 mt-4">
                {{ __('You can activate a dynamic key for this device to secure your account transactions. This key will only be available on this navigator.') }}
            </div>

            <div class="mt-5 space-y-6">
                <div class="flex items-center">
                    <div>
                        @if(!auth()->user()->two_factor_confirmed_at)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="red" class="size-9 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                        @else
                            <template x-if="!isValidKey">
                                {{ !$activatedDynamicKey ? print('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>') : print('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="green" class="w-8 h-8 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>')}}


                            </template>
                            <template x-if="isValidKey">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="green" class="w-8 h-8 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </template>
                        @endif
                    </div>

                    <div class="ms-3 font-semibold ">
                        @if(!auth()->user()->two_factor_confirmed_at)
                            <div class="text-sm text-gray-600">
                                {{ 'Please enable two factor authentication before enabling dynamic key.' }}
                            </div>
                        @else
                            <template x-if="!isValidKey">
                                <div class="text-sm text-gray-600">
                                    {{ !$activatedDynamicKey ? __('This device is ready for dynamic key enabling.') : 'Successfully activated!' }}
                                </div>
                            </template>
                            <template x-if="isValidKey">
                                <div class="text-sm text-gray-600">
                                    {{ 'Successfully activated!' }}
                                </div>
                            </template>
                        @endif
                    </div>
                </div>
            </div>

            @if(!$activatedDynamicKey)
                <div class="flex items-center mt-5">
                    @if(auth()->user()->two_factor_confirmed_at)
                        <div x-show="!isValidKey">
                            <x-confirms-password wire:then="toggleDynamicKeyModal">
                                <x-button wire:loading.attr="disabled">
                                    {{ __('Activate Dynamic Key') }}
                                </x-button>
                            </x-confirms-password>
                        </div>
                    @endif

                    <x-action-message class="ms-3" on="activated">
                        {{ __('Dynamic key activated.') }}
                    </x-action-message>
                </div>
            @endif

            <!-- Dynamic Key Activation Confirmation Modal -->
            <livewire:modals.dynamic-key-auth :clear-active="true" />
        </x-slot>
    </x-action-section>
</div>
</div>
