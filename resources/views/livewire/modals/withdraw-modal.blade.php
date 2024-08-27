<div>
    <x-dialog-modal wire:model="showModal" max-width="md">
        <x-slot name="title">
            <div class="flex">
                <svg class="size-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z"></path></svg>
                <h1 class="text-xl font-medium text-gray-900 ml-1">
                    Withdraw
                </h1>
            </div>

        </x-slot>

        <x-slot name="content">
            <div class="mb-4 grid grid-cols-2">
                <div>
                    <p class="text-base font-semibold mt-2">User </p>{{ $card?->user?->name }}
                </div>
                <div>
                    <p class="text-base font-semibold mt-2">Date </p>{{ now()->format('d/m/y H:i') }}
                </div>
                <div>
                    <p class="text-base font-semibold mt-2">Card Number </p>{{ $card?->card_number }}
                </div>
                <div>
                    <p class="text-base font-semibold mt-2">Card Type </p>{{ $card?->type }}
                </div>
                <div>
                    <p class="text-base font-semibold mt-2">Card Balance </p>${{ number_format($card->amount, 2) }}
                </div>
                <div>
                    <p class="text-base font-semibold mt-2">Withdraw Amount </p>${{ number_format($moneyQty, 2) }}
                </div>
            </div>

            <form wire:submit.prevent="withdraw">
                <div class="mb-4">
                    <label for="pin" class="block text-gray-700">PIN</label>
                    <input type="password" id="pin" :maxlength="4"
                           pattern="[0-9]*"
                           autocomplete="off"
                           wire:model="pin"
                           class="mt-1 block form-input w-full border-gray-300 rounded-md shadow-sm"/>
                    @error('pin')
                    <div class="flex mt-2 mb-[-20px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" color="red" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path></svg>
                        <span class="text-red-500 text-sm ml-1">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-4">
                <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                    Cancel
                </x-secondary-button>
                <x-button wire:click="withdraw">
                    Withdraw
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 2000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-4"
            class="fixed top-4 right-4 bg-green-400 text-white p-4 rounded-lg">
            {{ session('message') }}
        </div>
    @endif
</div>
