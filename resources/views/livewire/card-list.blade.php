<div class="max-w-7xl mx-auto">
    @if(!$passwordConfirmed)

        <div class="grid grid-cols-2 gap-4 sm:px-6 lg:px-8 ">
            <div
                class="p-6 lg:p-8 bg-white border-b border-gray-200 overflow-hidden shadow-xl sm:rounded-lg col-span-2">
                <h1 class=" text-2xl font-medium text-gray-900">
                    Cards
                </h1>

                <p class="mt-4 text-gray-500 leading-relaxed">
                    This section provides information about your cards and phone cards.
                </p>
                <p class="text-gray-500 leading-relaxed">
                    The process below is completely secure under the privacy policy guidelines. The information
                    displayed is sensitive; please do not reveal your personal details to others.
                </p>
                <x-button class="mt-6" wire:loading.attr="disabled" wire:click="confirmPassword">
                    Show Cards
                </x-button>
            </div>
        </div>

    @elseif ($passwordConfirmed)
        <div class=" sm:px-6 lg:px-8">
            <div class="bg-white border-b border-gray-200 overflow-hidden shadow-xl sm:rounded-lg ">
                <div class="p-8">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-2">
                        Cards
                    </h2>
                    <h5 class="font-semibold text-base text-gray-800 leading-tight mb-2">
                        Double click card to <span class="text-red-600">lock</span> / <span class="text-violet-600">unlock</span> for transactions.
                    </h5>
                    <div class="flex flex-row items-center justify-between gap-4 mt-4">
                        <div class="justify-start flex">
                            <div class="relative w-full md:w-72 mb-4">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="size-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                         fill="currentColor">
                                        <path
                                            d="M11 2C15.968 2 20 6.032 20 11C20 15.968 15.968 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2ZM11 18C14.8675 18 18 14.8675 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18ZM19.4853 18.0711L22.3137 20.8995L20.8995 22.3137L18.0711 19.4853L19.4853 18.0711Z">
                                        </path>
                                    </svg>
                                </div>
                                <input wire:model.live.debounce.300ms="search" type="search" id="search"
                                       class="block w-full px-4 py-2 ps-10 border border-gray-300 rounded-md outline-none focus:ring-0 focus:border-dianne-600 "
                                       placeholder="Search"/>
                            </div>

                        </div>

                        <div class="sm:hidden block mt-[-14px]">
                            <x-button wire:click="confirmnDynamicKey">Add</x-button>
                        </div>
                        <div class="sm:block hidden">
                            <x-button wire:click="confirmnDynamicKey">Add Card</x-button>
                        </div>
                    </div>

                    <h5 class="font-semibold text-base text-gray-800 leading-tight mb-2">
                        Cards filter
                    </h5>
                    <div>
                        <div class="flex mb-4">
                            <div class="flex">
                                <label for="unlocked" class="flex items-center cursor-pointer">
                                    <input
                                        type="checkbox"
                                        id="unlocked"
                                        wire:model.live.debounce="unlocked"
                                        class="hidden peer">
                                    <div class="w-12 h-6 bg-gray-200 rounded-full peer-checked:bg-violet-600 transition-all duration-300 ease-in-out
                                                after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300
                                                after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6
                                                relative shadow-inner group-hover:after:ring-4 group-hover:after:ring-violet-300">
                                    </div>
                                    <span class="ml-3 text-lg font-medium text-gray-700 peer-checked:text-violet-600 transition-colors duration-300">
                                        {{ 'Unlocked' }}
                                    </span>
                                </label>
                            </div>
                            <div class="flex ml-8">
                                <label for="locked" class="flex items-center cursor-pointer">
                                    <input
                                        type="checkbox"
                                        id="locked"
                                        wire:model.live.debounce="locked"
                                        class="hidden peer">
                                    <div class="w-12 h-6 bg-gray-200 rounded-full peer-checked:bg-red-600 transition-all duration-300 ease-in-out
                                                after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300
                                                after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6
                                                relative shadow-inner group-hover:after:ring-4 group-hover:after:ring-red-300">
                                    </div>
                                    <span class="ml-3 text-lg font-medium text-gray-700 peer-checked:text-red-600 transition-colors duration-300">
                                        {{ 'Locked' }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="grid-cols-2 grid gap-4 mt-4">
                        @if($cards->isEmpty())
                            <p class="mt-1 text-violet-500 leading-relaxed text-base font-semibold">
                                We not found cards. You be able to register your cards
                            </p>
                        @else
                            @foreach($cards as $card)
                                    <x-secondary-button
                                        x-data="{ pulsing: false }"
                                        x-on:dblclick="pulsing = true; setTimeout(() => pulsing = false, 300); $wire.dispatchToggleLockCard('{{ $card->card_number }}')"
                                        class="w-full col-span-2 md:col-span-1 h-20 text-xs md:text-base text-white flex justify-between items-center px-6 relative overflow-hidden
                                        {{ !$card->is_blocked
                                            ? 'bg-gradient-to-r from-violet-500 to-violet-900'
                                            : 'bg-gradient-to-r from-red-500 to-red-800' }}
                                        transition-all duration-300 ease-in-out"
                                        x-bind:class="{ 'scale-[0.97] brightness-110': pulsing }">
                                        <div class="absolute inset-0 bg-white opacity-0 transition-opacity duration-300"
                                             x-bind:class="{ 'animate-pulse-fast': pulsing }"></div>
                                            <div class="z-10 my-auto">
                                            @php
                                                    $cardNumber = $card->card_number;
                                                    $formattedCardNumber = '';
                                                    if (str_starts_with($cardNumber, '0')) {
                                                        $formattedCardNumber = substr($cardNumber, 1, 3) . ' ' . substr($cardNumber, 4);
                                                    } else {
                                                        $formattedCardNumber = substr($cardNumber, 0, 3) . '-' . substr($cardNumber, 3, 6) . '-' . substr($cardNumber, 9);
                                                    }
                                                @endphp
                                                {{ $formattedCardNumber }} ⟶ {{ $card->type }}
                                            </div>
                                            <div class="z-10 font-bold my-auto">
                                                ${{ number_format($card->amount, 0, ',', '.') }}
                                            </div>
                                    </x-secondary-button>
                            @endforeach
                        @endif
                        <div class="col-span-2">
                            {{ $cards->links() }}
                        </div>
                    </div>
                    <style>
                        @keyframes pulse-fast {
                            0%, 100% { opacity: 0;}
                            25%, 75% {opacity: 0.1;}
                            50% { opacity: 0.3; }
                        }
                        .animate-pulse-fast {
                            animation: pulse-fast 0.5s ease-in-out;
                        }
                    </style>
                </div>
            </div>
        </div>
    @endif
    <livewire:modals.dynamic-key-auth />
</div>
