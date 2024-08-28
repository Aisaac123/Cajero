<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo/>
        </x-slot>

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
            clearInputs() {
                this.codeInputs = ['', '', '', '', '', ''];
                this.focusInput(0);
            },
            init() {
                this.$nextTick(() => {
                    this.focusInput(0);
                });
            }
        }" x-init="init">
            <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <div class="mb-4 text-sm text-gray-600" x-cloak x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <x-validation-errors class="mb-4"/>

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="mt-4 w-60" x-show="!recovery">
                    <label for="code" class="text-sm font-semibold text-violet-700 mb-4">
                        {{ __('Two Factor Authentication code') }}
                    </label>
                    <div class="flex justify-between mt-2">
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
                    <input type="hidden" name="code" :value="codeInputs.join('')"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                            x-show="!recovery"
                            x-on:click="recovery = true">
                        {{ __('Use a recovery code') }}
                    </button>

                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                            x-show="recovery"
                            x-on:click="recovery = false">
                        {{ __('Use an authentication code') }}
                    </button>

                    <x-button class="ml-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
