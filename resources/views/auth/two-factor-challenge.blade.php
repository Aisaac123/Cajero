<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

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

                    this.focusNext(index);
                },
                handleKeydown(index, event) {
                    if (event.key === 'Backspace' && this.codeInputs[index] === '') {
                        event.preventDefault();
                        this.focusPrev(index);
                    }
                }
            }">
            <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <div class="mb-4 text-sm text-gray-600" x-cloak x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <x-validation-errors class="mb-4" />

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
                                x-model="codeInputs[index]"
                                x-ref="'code_' + index"
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
                    <input type="hidden" name="code" :value="codeInputs.join('')" />
                </div>

                <div class="mt-4" x-cloak x-show="recovery">
                    <x-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                    <x-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                            x-show="! recovery"
                            x-on:click="
                                recovery = true;
                                $nextTick(() => { $refs.recovery_code.focus() })
                            ">
                        {{ __('Use a recovery code') }}
                    </button>

                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                            x-cloak
                            x-show="recovery"
                            x-on:click="
                                recovery = false;
                                $nextTick(() => { $refs.code_0.focus() })
                            ">
                        {{ __('Use an authentication code') }}
                    </button>

                    <x-button class="ms-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
