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
            {{ __('Dynamic Key Activation') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Activate a dynamic key on this device for enhanced security transactions.') }}
        </x-slot>

        <x-slot name="content">
            <div class="max-w-xl text-sm text-gray-600">
                {{ __('You can activate a dynamic key for this device to secure your account further. This key will only be available on this device.') }}
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

                    <div class="ms-3">
                        @if(!auth()->user()->two_factor_confirmed_at)
                            <div class="text-sm text-gray-600">
                                {{ 'Please enable two factor authentication before active dynamic password' }}
                            </div>
                        @else
                            <template x-if="!isValidKey">
                                <div class="text-sm text-gray-600">
                                    {{ !$activatedDynamicKey ? __('This device is ready for dynamic key activation.') : 'Successfully activated!' }}
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
                            <x-confirms-password wire:then="confirmDynamicKeyActivation">
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
            <x-dialog-modal wire:model.live="confirmingDynamicKeyActivation">
                <x-slot name="title">
                    {{ __('Activate Dynamic Key') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Please confirm that you would like to activate the dynamic key on this device. This key will be tied to this navigator only.') }}

                    <div class="mt-4" x-data="{}" x-on:confirming-activation.window="setTimeout(() => $refs.key.focus(), 250)">

                        <x-input-error for="dynamicKey" class="mt-2" />
                    </div>
                    <div x-data="{ recovery: false }">
                        <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                            {{ __('Please confirm access to enable dynamic key by entering the authentication code provided by your authenticator application.') }}
                        </div>

                        <form wire:submit="submit">
                            <div class="mt-4 w-60" x-show="! recovery">
                                <div x-data="{
                                    recovery: false,
                                    codeInputs: ['', '', '', '', '', ''],
                                    focusNext(index) {
                                        if (index < 5) {
                                            this.$refs['code_' + (index + 1)].focus();
                                        }
                                    },
                                    focusPrev(index) {
                                        if (index > 0) {
                                            this.$refs['code_' + (index - 1)].focus();
                                        }
                                    },
                                    handleInput(index, event) {
                                        const input = event.target;
                                        const value = input.value;

                                        if (!/^\d$/.test(value)) {
                                            this.codeInputs[index] = '';
                                            return;
                                        }

                                        this.codeInputs[index] = value;
                                        this.updateCodeModel();

                                        this.focusNext(index);
                                    },
                                    handleKeydown(index, event) {
                                        if (event.key === 'Backspace' && this.codeInputs[index] === '') {
                                            event.preventDefault();
                                            this.focusPrev(index);
                                        }
                                    },
                                    updateCodeModel() {
                                        $wire.set('code', this.codeInputs.join(''));
                                    }
                                }"
                                     x-show="! recovery"
                                     class="mt-4">
                                    <x-label for="code" value="{{ __('Two Factor Authentication code') }}" class="text-lg font-semibold text-violet-700 mb-2"/>
                                    <div class="flex justify-between">
                                        <template x-for="(digit, index) in codeInputs" :key="index">
                                            <input
                                                type="text"
                                                x-model="codeInputs[index]"
                                                x-ref="code_${index}"
                                                x-on:input="handleInput(index, $event)"
                                                x-on:keydown="handleKeydown(index, $event)"
                                                class="size-10 text-center text-xl font-bold border-1 border-violet-500 rounded-lg
                                                       focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent
                                                       bg-violet-50 text-violet-700 placeholder-violet-400
                                                       transition duration-150 ease-in-out mr-2
                                                       shadow-sm hover:shadow-md focus:shadow-lg"
                                                maxlength="1"
                                                inputmode="numeric"
                                                autocomplete="one-time-code"
                                                :autofocus="index === 0"
                                                required
                                            />
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <x-validation-errors class="mt-4" />
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$toggle('confirmingDynamicKeyActivation')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-button class="ms-3"
                              wire:click="submit"
                              wire:loading.attr="disabled">
                        {{ __('Activate') }}
                    </x-button>
                </x-slot>
            </x-dialog-modal>
        </x-slot>
    </x-action-section>
</div>
</div>
