<div>
    @if($modal)
        <x-dialog-modal wire:model.live="confirmingDynamicKeyActivation">
            <x-slot name="title">
                {{ !$transactional ? __('Dynamic Key') : __('Transactional Dynamic Key') }}
            </x-slot>

            <x-slot name="content">
                {{  !$transactional ?
                    __('Please confirm two factor authentication code provided by your authenticator application.')
                    : __('Please confirm transactional dynamic code provided by your authenticated session.')
                }}
                @if(!auth()->user()->two_factor_confirmed_at && !$transactional)
                    <div class="flex items-center mt-4">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                                 stroke="red" class="size-9 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>

                        <div class="ms-3 font-semibold">
                            <div class="text-sm text-gray-600">
                                {{ 'Please enable two factor authentication before this action.' }}
                            </div>

                        </div>
                    </div>
                @elseif(!auth()->user()->dynamic_key_id && $transactional)
                    <div class="flex items-center mt-4">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                                 stroke="red" class="size-9 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>

                        <div class="ms-3 font-semibold">
                            <div class="text-sm text-gray-600">
                                {{ 'Please enable transactional dynamic key before this action.' }}
                            </div>

                        </div>
                    </div>
                @else
                    <div class="mt-4">
                        <x-input-error for="dynamicKey" class="mt-2" />
                    </div>
                    <div x-data="{
                    recovery: false,
                    codeInputs: ['', '', '', '', '', ''],
                    focusInput(index) {
                        const input = document.getElementById(`code_${index}`);
                        if (input) {
                            input.focus();
                            input.select();
                        }
                    },
                    handleInput(index, event) {
                        const value = event.target.value;
                        if (value.length > 0) {
                            this.codeInputs[index] = value[value.length - 1];
                            this.updateCodeModel();
                            if (index < 5) {
                                this.focusInput(index + 1);
                            }
                        }
                    },
                    handleKeydown(index, event) {
                        if (event.key === 'Backspace') {
                            if (this.codeInputs[index] === '' && index > 0) {
                                event.preventDefault();
                                this.focusInput(index - 1);
                            }
                        } else if (event.key === 'ArrowLeft' && index > 0) {
                            event.preventDefault();
                            this.focusInput(index - 1);
                        } else if (event.key === 'ArrowRight' && index < 5) {
                            event.preventDefault();
                            this.focusInput(index + 1);
                        }
                    },
                    updateCodeModel() {
                        $wire.set('code', this.codeInputs.join(''));
                    },
                    clearInputs() {
                        this.codeInputs = ['', '', '', '', '', ''];
                        this.updateCodeModel();
                        this.focusInput(0);
                    },
                    init() {
                        this.$nextTick(() => {
                            this.focusInput(0);
                        });
                    }
                }" x-init="init">
                        <form wire:submit.prevent="submit">
                            <div class="mt-4 w-full" x-show="! recovery">
                                <x-label for="code" value="{{ !$transactional ? 'Two Factor Authentication code' : 'Transactional Dynamic Key' }}" class="text-lg font-semibold text-violet-700 mb-2"/>
                                <div class="flex">
                                    <div class="flex justify-between">
                                        <template x-for="(digit, index) in codeInputs" :key="index">
                                            <input
                                                type="text"
                                                :id="'code_' + index"
                                                x-model="codeInputs[index]"
                                                x-on:input="handleInput(index, $event)"
                                                x-on:keydown="handleKeydown(index, $event)"
                                                @focus="$event.target.select()"
                                                class="size-10 text-center text-xl font-bold border-1 border-violet-500 rounded-lg
                                               focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent
                                               bg-violet-50 text-violet-700 placeholder-violet-400
                                               transition duration-150 ease-in-out mr-2
                                               shadow-sm hover:shadow-md focus:shadow-lg"
                                                maxlength="1"
                                                inputmode="numeric"
                                                autocomplete="one-time-code"
                                                required
                                            />
                                        </template>
                                    </div>
                                    @if($clearActive)
                                        <div class="mb-[-10px] ml-4">
                                            <x-secondary-button @click.prevent="clearInputs" class="mt-[0.2rem]">
                                                {{ __('Clear') }}
                                            </x-secondary-button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <x-validation-errors class="mt-4" />
                    </div>
                @endif
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
    @else
        <h1 class="text-lg font-medium text-gray-900">
            {{ !$transactional ? __('Dynamic Key') : __('Transactional Dynamic Key') }}
        </h1>
        <div class="mt-4 text-sm text-gray-600">
            {{  !$transactional ?
                __('Please confirm two factor authentication code provided by your authenticator application.')
                : __('Please confirm transactional dynamic code provided by your authenticated session.')
            }}
            <div x-data="{
            recovery: false,
            codeInputs: ['', '', '', '', '', ''],
            focusInput(index) {
                const input = document.getElementById(`code_${index}`);
                if (input) {
                    input.focus();
                    input.select();
                }
            },
            handleInput(index, event) {
                const value = event.target.value;
                if (value.length > 0) {
                    this.codeInputs[index] = value[value.length - 1];
                    this.updateCodeModel();
                    if (index < 5) {
                        this.focusInput(index + 1);
                    }
                }
            },
            handleKeydown(index, event) {
                if (event.key === 'Backspace') {
                    if (this.codeInputs[index] === '' && index > 0) {
                        event.preventDefault();
                        this.focusInput(index - 1);
                    }
                } else if (event.key === 'ArrowLeft' && index > 0) {
                    event.preventDefault();
                    this.focusInput(index - 1);
                } else if (event.key === 'ArrowRight' && index < 5) {
                    event.preventDefault();
                    this.focusInput(index + 1);
                }
            },
            updateCodeModel() {
                $wire.set('code', this.codeInputs.join(''));
            },
            clearInputs() {
                this.codeInputs = ['', '', '', '', '', ''];
                this.updateCodeModel();
                this.focusInput(0);
            },
            init() {
                this.$nextTick(() => {
                    this.focusInput(0);
                });
            }
        }" x-init="init">
                <form wire:submit.prevent="submit">
                    <div class="mt-4 w-full" x-show="! recovery">
                        <x-label for="code" value="{{ !$transactional ? 'Two Factor Authentication code' : 'Transactional Dynamic Key' }}" class="text-lg font-semibold text-violet-700 mb-2"/>
                        <div class="flex">
                            <div class="flex justify-between">
                                <template x-for="(digit, index) in codeInputs" :key="index">
                                    <input
                                        type="text"
                                        :id="'code_' + index"
                                        x-model="codeInputs[index]"
                                        x-on:input="handleInput(index, $event)"
                                        x-on:keydown="handleKeydown(index, $event)"
                                        @focus="$event.target.select()"
                                        class="size-10 text-center text-xl font-bold border-1 border-violet-500 rounded-lg
                                       focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent
                                       bg-violet-50 text-violet-700 placeholder-violet-400
                                       transition duration-150 ease-in-out mr-2
                                       shadow-sm hover:shadow-md focus:shadow-lg"
                                        maxlength="1"
                                        inputmode="numeric"
                                        autocomplete="one-time-code"
                                        required
                                    />
                                </template>
                            </div>
                            @if($clearActive)
                                <div class="mb-[-10px] ml-4">
                                    <x-secondary-button @click.prevent="clearInputs" class="mt-[0.2rem]">
                                        {{ __('Clear') }}
                                    </x-secondary-button>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
                <x-validation-errors class="mt-4" />
            </div>
            <div class="mt-4">
                <x-input-error for="dynamicKey" class="mt-2" />
            </div>
        </div>

        <div class="flex flex-row justify-end px-6 py-4 text-end  mt-2">
            <x-secondary-button wire:click="$toggle('confirmingDynamicKeyActivation')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ms-3"
                      wire:click="submit"
                      wire:loading.attr="disabled">
                {{ __('Activate') }}
            </x-button>
        </div>
   @endif
</div>
