<div class="max-w-7xl mx-auto">
            @if(!$passwordConfirmed)
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200 overflow-hidden shadow-xl sm:rounded-lg mx-4 sm:mx-0 col-span-2">
                        <h1 class=" text-2xl font-medium text-gray-900">
                            Cards
                        </h1>

                        <p class="mt-4 text-gray-500 leading-relaxed">
                            This section provides information about your bank cards.
                        </p>
                        <p class="text-gray-500 leading-relaxed">
                            The process below is completely secure under the privacy policy guidelines. The information displayed is sensitive; please do not reveal your personal details to others.
                        </p>
                        <x-confirms-password wire:then="confirmPassword">
                            <x-button class="mt-6" wire:loading.attr="disabled">
                                Start
                            </x-button>
                        </x-confirms-password>
                    </div>
                </div>
            @elseif ($passwordConfirmed)
                <div class=" sm:px-6 lg:px-8 ">
                    <div class="bg-white border-b border-gray-200 overflow-hidden shadow-xl sm:rounded-lg ">
                        <div class="p-6">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-2">
                Cards
            </h2>
                <div class="flex flex-row items-center justify-between gap-4 mt-4">
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
                               placeholder="Search" />
                    </div>
                    <a href="{{ route('cards.create') }}">
                        <x-button>
                            Add Card
                        </x-button>
                    </a>
                </div>
                <div class=" grid-cols-2 grid gap-4 mt-4">
                    @if($cards->isEmpty())
                        <p class="mt-1 text-violet-500 leading-relaxed text-base font-semibold">
                            We not found cards!
                        </p>
                    @else
                        @foreach($cards as $card)
                            <x-secondary-button
                                class="mb-4 w-full col-span-2 md:col-span-1 h-20 text-xs md:text-base flex justify-between hover:text-white hover:bg-violet-400 focus:ring-violet-600'"
                                wire:click="setSelectedCard('{{ $card->card_number }}')">
                                <div>
                                    {{ $card->card_number }}
                                    -
                                    {{ $card->type }}

                                </div>
                                <div>
                                    ${{ number_format($card->amount, 0, ',', '.') }}
                                </div>
                            </x-secondary-button>
                        @endforeach
                    @endif
                    <div class="col-span-2">
                        {{ $cards->links() }}
                    </div>
                </div>
            </div>
                    </div>
                </div>
        @endif
</div>
