<div>
@if($modal)
    <x-dialog-modal wire:model.live="confirmingDynamicKeyActivation">
        <x-slot name="title">
            {{ __('Activate Dynamic Key') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Please confirm two factor authentication code provided by your authenticator application.') }}

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
                        <x-label for="code" value="{{ __('Two Factor Authentication code') }}" class="text-lg font-semibold text-violet-700 mb-2"/>
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
            {{ __('Activate Dynamic Key') }}
        </h1>
        <div class="mt-4 text-sm text-gray-600">
            {{ __('Please confirm two factor authentication code provided by your authenticator application.') }}

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
                        <x-label for="code" value="{{ __('Two Factor Authentication code') }}" class="text-lg font-semibold text-violet-700 mb-2"/>
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
