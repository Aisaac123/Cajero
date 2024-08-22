<div>
    @if(!$passwordConfirmed && !$success)
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

        @elseif($passwordConfirmed && !$success)
            <div
                x-data="{
                    timeLeft: 5*60,
                    intervalId: null,
                    startTimer() {
                        this.intervalId = setInterval(() => {
                            if (this.timeLeft > 0) {
                                this.timeLeft--;
                            } else {
                                clearInterval(this.intervalId);
                                $wire.endWithdraw();
                            }
                        }, 1000);
                    }
                }"
                x-init="
                    startTimer();
                    $wire.on('successWithdraw', () => {
                        clearInterval(intervalId);
                        timeLeft = 1*60;
                        startTimer();
                    });
                "
            >
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
                        <div class="flex mt-4">
                            <x-button class="mt-4" wire:click="openWithdrawalModal">
                                Withdraw
                            </x-button>
                            @error('openModal')
                            <div class="flex mb-[-20px] ml-3 mt-5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" color="red" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path></svg>
                                <span class="text-red-500 text-sm ml-1">{{ $message }}</span>
                            </div>
                            @enderror
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
                            <x-secondary-button class="mb-4 w-full h-14 text-xs md:text-sm flex justify-between {{ $selectedCard?->card_number === $card->card_number ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}"
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
                        <div class="mt-4">
                            {{ $cards->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <livewire:modals.withdraw-modal :card="$card" />

        @elseif($success)
            <div class="gap-4 mx-4 sm:mx-0">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:col-span-2 col-span-1 mb-4">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h1 class=" text-2xl font-medium text-gray-900">
                            Withdraw Success
                        </h1>
                        <p class="mt-4 text-gray-500 leading-relaxed">
                            Withdraw process was successfully. <span class="font-semibold">You will be redirected in 1 minute.</span>
                        </p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:col-span-2 col-span-1">
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90" class="fixed top-4 right-4 bg-green-400 text-white p-4 rounded-lg shadow-lg">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <h1 class="text-lg font-semibold">
                                Withdraw Successfully!
                            </h1>
                        </div>
                    </div>
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200 shadow-sm rounded-lg">
                        <h1 class="text-2xl font-semibold text-gray-900 mb-4">
                            Withdraw Information
                        </h1>

                        <!-- User Information -->
                        <div class="mb-6">
                            <h2 class="text-xl font-medium text-gray-700 mb-2">User Information</h2>
                            <p class="text-gray-600">
                                <strong>Name:</strong> {{ Auth::user()->name }}
                            </p>
                            <p class="text-gray-600">
                                <strong>Email:</strong> {{ Auth::user()->email }}
                            </p>
                        </div>

                        <!-- Transaction Details -->
                        <div>
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor"><path d="M22.0049 6.99979H23.0049V16.9998H22.0049V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V6.99979ZM20.0049 16.9998H14.0049C11.2435 16.9998 9.00488 14.7612 9.00488 11.9998C9.00488 9.23836 11.2435 6.99979 14.0049 6.99979H20.0049V4.99979H4.00488V18.9998H20.0049V16.9998ZM21.0049 14.9998V8.99979H14.0049C12.348 8.99979 11.0049 10.3429 11.0049 11.9998C11.0049 13.6566 12.348 14.9998 14.0049 14.9998H21.0049ZM14.0049 10.9998H17.0049V12.9998H14.0049V10.9998Z"></path></svg>
                                <h2 class="text-xl font-medium text-gray-700 mb-2 ml-2">Transaction Details</h2>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <p class="text-gray-800 mb-2">
                                    <strong>Card Number:</strong> {{ $data['cardNumber'] }}
                                </p>
                                <p class="text-gray-800 mb-2">
                                    <strong>Card Type:</strong> {{ $data['cardType'] }}
                                </p>
                                <p class="text-gray-800 mb-2">
                                    <strong>Quantity:</strong> ${{ number_format($data['quantity'], 2) }}
                                </p>
                                <p class="text-gray-800 mb-2">
                                    <strong>Amount:</strong> ${{ number_format($data['amount'], 2) }}
                                </p>
                                <div class="mt-4">
                                    <strong class="text-gray-700">Denominations:</strong>
                                    <div class="space-y-2 mt-2">
                                        @foreach($data['denominationsCounts']['denominations'] as $index => $denomination)
                                            <div class="flex items-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                                <!-- Icon -->
                                                <div class="flex-shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12.0004 16C14.2095 16 16.0004 14.2091 16.0004 12 16.0004 9.79086 14.2095 8 12.0004 8 9.79123 8 8.00037 9.79086 8.00037 12 8.00037 14.2091 9.79123 16 12.0004 16ZM21.0049 4.00293H3.00488C2.4526 4.00293 2.00488 4.45064 2.00488 5.00293V19.0029C2.00488 19.5552 2.4526 20.0029 3.00488 20.0029H21.0049C21.5572 20.0029 22.0049 19.5552 22.0049 19.0029V5.00293C22.0049 4.45064 21.5572 4.00293 21.0049 4.00293ZM4.00488 15.6463V8.35371C5.13065 8.017 6.01836 7.12892 6.35455 6.00293H17.6462C17.9833 7.13193 18.8748 8.02175 20.0049 8.3564V15.6436C18.8729 15.9788 17.9802 16.8711 17.6444 18.0029H6.3563C6.02144 16.8742 5.13261 15.9836 4.00488 15.6463Z"></path></svg>
                                                </div>
                                                <!-- Text -->
                                                <div class="ml-3">
                                                    <p class="text-gray-800 text-lg font-bold">${{ number_format($denomination, 2) }}</p>
                                                    <p class="text-gray-600">Quantity: <span class="font-medium">{{ $data['denominationsCounts']['counts'][$index] }}</span></p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <x-button wire:click="resetComponent">

                                </x-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
