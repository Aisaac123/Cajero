<div>
    @if(!$passwordConfirmed)

        <div class="p-6 lg:p-8 bg-white border-b border-gray-200 mx-4 sm:mx-0">
            <h1 class=" text-2xl font-medium text-gray-900">
                You are about to start the withdrawal process
            </h1>

            <p class="mt-4 text-gray-500 leading-relaxed">
                You are about to start the process of withdrawing money.
            </p>
            <p class="text-gray-500 leading-relaxed">
                The process below is completely secure under the privacy policy guidelines. The information to be displayed is sensitive information, please do not reveal your personal information to other people.
            </p>

            <div class="flex mt-4">
                <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z"></path></svg>
                <p class="text-gray-700 leading-relaxed ml-2">
                    You will be disconnected after <span class="font-bold text-red-600">5 minutes</span> of initiating the withdrawal process or in the event of a <span class="font-bold text-red-600">failure</span>.
                </p>
            </div>

            <x-confirms-password wire:then="confirmed">
                <x-button class="mt-6" wire:loading.attr="disabled">
                    Start
                </x-button>
            </x-confirms-password>
        </div>

    @else
        <div x-data="{ timeLeft: @entangle('timeLeft') }" x-init="
            setInterval(() => {
                if (timeLeft > 0) {
                    timeLeft--;
                } else {
                    $wire.endWithdraw();
                }
            }, 5 * 60 * 1000);
        ">
        </div>
        <div class="lg:grid-cols-2 grid-cols-1 grid gap-4 mx-4 sm:mx-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:col-span-2 col-span-1">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class=" text-2xl font-medium text-gray-900">
                        Withdraw Process
                    </h1>
                    <p class="mt-4 text-gray-500 leading-relaxed">
                        The withdrawal process involves securely accessing your credit cards, selecting the desired amount, and confirming the transaction. Please ensure your personal information is protected throughout this process.
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white">
                    <h1 class="text-xl font-medium text-gray-900">
                        Select an ammount of cash
                    </h1>
                    <p class="mt-1 text-gray-500 leading-relaxed">
                        Please select the desired amount of money to proceed.
                    </p>
                    <hr class="mb-4 mt-4">

                    <div class="grid xs:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40 xs:gap-52">
                        <x-secondary-button class="mt-4 w-full border-b-blue-200 text-xs md:text-sm
                        {{ $moneyQty === 20000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}"
                                            wire:click="setMoneyQty(20000)">
                            $20.000
                        </x-secondary-button>
                        <x-secondary-button class="mt-4 w-full border-b-blue-200 text-xs md:text-sm
                        {{ $moneyQty === 50000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}"
                                            wire:click="setMoneyQty(50000)">
                            $50.000
                        </x-secondary-button>
                    </div>
                    <div class="grid xs:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40 xs:gap-52">
                        <x-secondary-button class="mt-6 w-full border-b-blue-200 text-xs md:text-sm
                        {{ $moneyQty === 100000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}"
                                            wire:click="setMoneyQty(100000)">
                            $100.000
                        </x-secondary-button>
                        <x-secondary-button class="mt-6 w-full border-b-blue-200 text-xs md:text-sm
                        {{ $moneyQty === 200000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}"
                                            wire:click="setMoneyQty(200000)">
                            $200.000
                        </x-secondary-button>
                    </div>
                    <div class="grid xs:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40 xs:gap-52">
                        <x-secondary-button class="mt-6 w-full border-b-blue-200 text-xs md:text-sm
                        {{ $moneyQty === 300000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}"
                                            wire:click="setMoneyQty(300000)">
                            $300.000
                        </x-secondary-button>
                        <x-secondary-button class="mt-6 w-full border-b-blue-200 text-xs md:text-sm
                        {{ $moneyQty === 500000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}"
                                            wire:click="setMoneyQty(500000)">
                            $500.000
                        </x-secondary-button>
                    </div>
                    <div class="grid xs:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40 xs:gap-52">
                        <x-secondary-button class="mt-6 w-full border-b-blue-200 text-xs md:text-sm
                        {{ $moneyQty === 1000000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}"
                                            wire:click="setMoneyQty(1000000)">
                            $1.000.000
                        </x-secondary-button>
                        <x-secondary-button class="mt-6 w-full border-b-blue-200 text-xs md:text-sm">
                            Otro
                        </x-secondary-button>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white">
                    <h1 class=" text-xl font-medium text-gray-900">
                        Select Your Card
                    </h1>
                    <p class="mt-1 text-gray-500 leading-relaxed">
                        Please select your card account to proceed.
                    </p>
                    <hr class="mb-8 mt-4">
                    @php
                        $cards = auth()->user()->cards()->paginate(3);
                    @endphp
                    @foreach($cards as $card)
                        <x-secondary-button class="mb-4 w-full h-14 text-xs md:text-sm {{ $selectedCard?->card_number === $card->card_number ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}"
                                            wire:click="setSelectedCard('{{ $card->card_number }}')">
                            <div class="flex justify-between">
                                {{ $card->card_number }}
                                -
                                {{ $card->type }}
                            </div>
                        </x-secondary-button>
                    @endforeach
                    <div class="mt-4">
                        {{ $cards->links() }}
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>
