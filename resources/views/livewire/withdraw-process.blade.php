<div>
    @if(!$passwordConfirmed && !$success)

        <!-- Withdraw Options Menu -->
        <div class="grid grid-cols-2 gap-4">
            <div
                class="p-6 lg:p-8 bg-white border-b border-gray-200 overflow-hidden shadow-xl sm:rounded-lg mx-4 sm:mx-0 col-span-2">

                <!-- Withdraw Message -->

                <h1 class=" text-2xl font-medium text-gray-900">
                    You are about to start the withdrawal process
                </h1>

                <p class="mt-4 text-gray-500 leading-relaxed">
                    You are about to start the process of withdrawing cash.
                </p>
                <p class="text-gray-500 leading-relaxed">
                    The process below is completely secure under the privacy policy guidelines. The information to be
                    displayed is sensitive information, please do not reveal your personal information to other people.
                </p>

                <div class="flex mt-4">
                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z"></path>
                    </svg>
                    <p class="text-gray-700 leading-relaxed ml-2">
                        You will be disconnected after <span class="font-bold text-red-600">30 seconds</span> of
                        initiating
                        the withdrawal process or in the event of a <span class="font-bold text-red-600">failure</span>.
                    </p>
                </div>
                <div class="flex items-center mt-4">
                    <div>
                        @if(!auth()->user()->dynamic_key_id)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                                 stroke="red" class="size-9 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="green" class="w-8 h-8 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        @endif
                    </div>

                    <div class="ms-3 font-semibold">
                        @if(!auth()->user()->dynamic_key_id)
                            <div class="text-sm text-gray-600">
                                {{ 'Please enable transactional dynamic key before start withdraw process on your profile configuration.' }}
                            </div>
                        @else
                            <div class="text-sm text-gray-600">
                                {{ 'Successfully activated!' }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Start Withdraw -->
            @if(auth()->user()->dynamic_key_id)

                <!-- Cards Withdraw Option -->
                <div
                    class="p-6 lg:p-8 bg-white border-b border-gray-200 overflow-hidden shadow-xl sm:rounded-lg mx-4 sm:mx-0 col-span-2 md:col-span-1 flex-1">
                    <h1 class=" text-2xl font-medium text-gray-900">
                        Card Withdraw
                    </h1>

                    <p class="text-gray-500 leading-relaxed">
                        Use your card to quickly and securely withdraw cash from your account.
                    </p>

                        <x-button wire:click="confirmPassword(false)" class="mt-6" wire:loading.attr="disabled">
                            Start
                        </x-button>
                </div>

                <!-- Phone Withdraw Option -->

                <div
                    class="p-6 lg:p-8 bg-white border-b border-gray-200 overflow-hidden shadow-xl sm:rounded-lg mx-4 sm:mx-0 col-span-2 md:col-span-1">
                    <h1 class="text-2xl font-medium text-gray-900">
                        Phone Number Withdraw
                    </h1>

                    <p class="text-gray-500 leading-relaxed">
                        Use your phone number to easily withdraw cash from your account.
                    </p>

                    <x-button wire:click="confirmPassword(true)" class="mt-6" wire:loading.attr="disabled">
                        Start
                    </x-button>
                </div>
            @endif
            <livewire:modals.dynamic-key-auth/>
        </div>

    @elseif ($passwordConfirmed && !$success)

        <!-- Withdraw Modals -->
        <livewire:modals.withdraw-modal/>

        <!-- Withdraw Start Section  -->

        <div x-data="{
                    timeLeft: 30,
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
                }" x-init="
                    startTimer();
                    $wire.on('successWithdraw', () => {
                        clearInterval(intervalId);
                        timeLeft = 1*60;
                        startTimer();
                    });">
            @if(!$isPhone)
                <div class="lg:grid-cols-2 grid-cols-1 grid gap-4 mx-4 sm:mx-0">
                    @php
                        $otherMoneyQty = $moneyQty !== 20000 && $moneyQty !== 50000
                        && $moneyQty !== 100000 && $moneyQty !== 200000 && $moneyQty !== 300000
                        && $moneyQty !== 500000 && $moneyQty !== 1000000
                    @endphp
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:col-span-2 col-span-1">
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                            <h1 class=" text-2xl font-medium text-gray-900">
                                Withdraw Process
                            </h1>
                            <p class="mt-4 text-gray-500 leading-relaxed">
                                The withdrawal process involves securely accessing your credit cards, selecting the
                                desired
                                amount, and confirming the transaction. Please ensure your personal information is
                                protected
                                throughout this process.
                            </p>
                        </div>
                    </div>


                    <!-- Cash Amount Options -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                        <div class="p-6 lg:p-8 bg-white">
                            <h1 class="text-xl font-medium text-gray-900">
                                Select an ammount of cash
                            </h1>
                            <p class="mt-1 text-gray-500 leading-relaxed">
                                Please select the desired cash amount to proceed.
                            </p>
                            <hr class="mb-4 mt-4">

                            <div class="grid xs:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40 xs:gap-52">
                                <x-secondary-button class="mt-4 w-full border-b-violet-300 text-xs md:text-sm
                            {{ $moneyQty === 20000 ? 'bg-gradient-to-r from-blue-400 to-blue-800 text-white hover:bg-blue-700 focus:ring-blue-700' : 'bg-gradient-to-r from-blue-50 to-blue-100'  }}"
                                                    wire:click="setMoneyQty(20000)">
                                    $20.000
                                </x-secondary-button>
                                <x-secondary-button class="mt-4 w-full border-b-violet-300 text-xs md:text-sm
                            {{ $moneyQty === 50000 ? 'bg-gradient-to-r from-blue-400 to-blue-800 text-white hover:bg-blue-700 focus:ring-blue-700' : 'bg-gradient-to-r from-blue-50 to-blue-100'  }}"
                                                    wire:click="setMoneyQty(50000)">
                                    $50.000
                                </x-secondary-button>
                            </div>
                            <div class="grid xs:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40 xs:gap-52">
                                <x-secondary-button class="mt-6 w-full border-b-violet-300 text-xs md:text-sm
                            {{ $moneyQty === 100000 ? 'bg-gradient-to-r from-blue-400 to-blue-800 text-white hover:bg-blue-700 focus:ring-blue-700' : 'bg-gradient-to-r from-blue-50 to-blue-100'  }}"
                                                    wire:click="setMoneyQty(100000)">
                                    $100.000
                                </x-secondary-button>
                                <x-secondary-button class="mt-6 w-full border-b-violet-300 text-xs md:text-sm
                            {{ $moneyQty === 200000 ? 'bg-gradient-to-r from-blue-400 to-blue-800 text-white hover:bg-blue-700 focus:ring-blue-700' : 'bg-gradient-to-r from-blue-50 to-blue-100'  }}"
                                                    wire:click="setMoneyQty(200000)">
                                    $200.000
                                </x-secondary-button>
                            </div>
                            <div class="grid xs:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40 xs:gap-52">
                                <x-secondary-button class="mt-6 w-full border-b-violet-300 text-xs md:text-sm
                            {{ $moneyQty === 300000 ? 'bg-gradient-to-r from-blue-400 to-blue-800 text-white hover:bg-blue-700 focus:ring-blue-700' : 'bg-gradient-to-r from-blue-50 to-blue-100'  }}"
                                                    wire:click="setMoneyQty(300000)">
                                    $300.000
                                </x-secondary-button>
                                <x-secondary-button class="mt-6 w-full border-b-violet-300 text-xs md:text-sm
                            {{ $moneyQty === 500000 ? 'bg-gradient-to-r from-blue-400 to-blue-800 text-white hover:bg-blue-700 focus:ring-blue-700' : 'bg-gradient-to-r from-blue-50 to-blue-100'  }}"
                                                    wire:click="setMoneyQty(500000)">
                                    $500.000
                                </x-secondary-button>
                            </div>
                            <div class="grid xs:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40 xs:gap-52">
                                <x-secondary-button class="mt-6 w-full border-b-violet-300 text-xs md:text-sm
                            {{ $moneyQty === 1000000 ? 'bg-gradient-to-r from-blue-400 to-blue-800 text-white hover:bg-blue-700 focus:ring-blue-700' : 'bg-gradient-to-r from-blue-50 to-blue-100'  }}"
                                                    wire:click="setMoneyQty(1000000)">
                                    $1.000.000
                                </x-secondary-button>
                                <x-secondary-button class="mt-6 w-full border-b-violet-300 text-xs md:text-sm
                            {{ $otherMoneyQty && $otherActive ? 'bg-gradient-to-r from-pink-400 to-pink-700 text-white hover:bg-pink-700 focus:ring-pink-700' : 'bg-gradient-to-r from-pink-50 to-pink-200' }}"
                                                    wire:click="changeOtherState">
                                    Other
                                </x-secondary-button>
                            </div>
                            <div class="mt-6">
                                <div class="flex">
                                    <div x-if="isValidKey">
                                    </div>
                                    <x-button wire:click="openWithdrawalModal" class="h-[2.2rem]">
                                        Withdraw
                                    </x-button>
                                    <div
                                        x-data="{ show: @entangle('otherMoneyQty') && @entangle('otherActive') }"
                                        x-show="show"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 transform scale-90"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-90"
                                        class="relative w-full ml-4">
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                                <svg class="size-6 text-pink-400" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="1.7"
                                                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <input
                                                type="number"
                                                wire:model.live="moneyQty"
                                                placeholder="Amount..."
                                                class="block w-full pl-9 pr-8 h-[2.2rem] border-1 border-pink-400 rounded-lg text-pink-700 placeholder-pink-400
                                                   bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-600 focus:border-transparent
                                                   transition duration-150 ease-in-out
                                                   text-base font-normal
                                                   shadow-lg hover:shadow-md focus:shadow-lg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('openModal')
                            <div class="flex mb-[-20px] mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" color="red" viewBox="0 0 24 24"
                                     fill="currentColor">
                                    <path
                                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path>
                                </svg>
                                <span class="text-red-500 text-sm ml-1">{{ $message }}</span>
                            </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Cards Options -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-full">
                        <div class="p-6 lg:p-8 bg-white">
                            <h1 class=" text-xl font-medium text-gray-900">
                                {{ $validDynamicKey ? 'Select Your Card' : 'Insert Your Card' }}
                            </h1>
                            <p class="mt-1 text-gray-500 leading-relaxed">
                                {{ $validDynamicKey ? 'Please select your card account to proceed.' : 'Please enter your card number to proceed.' }}

                            </p>
                            <hr class="mb-8 mt-4">
                            @if(!$validDynamicKey)
                                <div>
                                    <div class="w-full">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6 text-violet-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                          d="M3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM20.0049 10.9998H4.00488V18.9998H20.0049V10.9998ZM20.0049 8.99979V4.99979H4.00488V8.99979H20.0049ZM14.0049 14.9998H18.0049V16.9998H14.0049V14.9998Z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input
                                                type="text"
                                                wire:model.live="cardNumber"
                                                maxlength="11"
                                                pattern="\d{11}"
                                                placeholder="Card Number"
                                                class="block w-full pl-9 pr-8 h-[3rem] border-1 border-violet-500 rounded-lg text-violet-700 placeholder-violet-400
                                                       bg-violet-50 focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent
                                                       transition duration-150 ease-in-out
                                                       text-base font-normal
                                                       shadow-lg hover:shadow-md focus:shadow-lg">
                                        </div>
                                    </div>
                                </div>
                            @else
                                @php
                                    $validCards = $cards->filter(function($card) {
                                        return !str_starts_with($card->card_number, '0');
                                    });
                                @endphp
                                @if($cards->isEmpty() || $validCards->isEmpty())
                                    <p class="mt-1 text-violet-500 leading-relaxed text-base font-semibold">
                                        We not found valid cards 😔
                                    </p>
                                @else
                                    @foreach($validCards as $card)
                                        <x-secondary-button
                                            class="mb-4 w-full h-14 text-xs md:text-sm flex justify-between {{ $selectedCard?->card_number === $card->card_number ? 'bg-gradient-to-r from-violet-400 to-violet-900 text-white hover:bg-violet-700 focus:ring-violet-700' : 'bg-gradient-to-r from-violet-50 to-violet-100' }}"
                                            wire:click="setSelectedCard('{{ $card->card_number }}')">
                                            <div>
                                                @php
                                                    $cardNumber = $card->card_number;
                                                    $formattedCardNumber = substr($cardNumber, 0, 3) . '-' . substr($cardNumber, 3, 6) . '-' . substr($cardNumber, 9);
                                                @endphp
                                                {{ $formattedCardNumber }} ⟶ {{ $card->type }}
                                            </div>
                                            <div>
                                                ${{ number_format($card->amount, 0, ',', '.') }}
                                            </div>
                                        </x-secondary-button>
                                    @endforeach
                                @endif
                                <div class="mt-4">
                                    {{ $cards->links() }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            @else

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white">
                        <h1 class=" text-xl font-medium text-gray-900">Select Your Phone Card</h1>
                        <p class="mt-1 text-gray-500 leading-relaxed">{{ $validDynamicKey ? 'Please select your phone card to proceed.' : 'Please enter your phone number to proceed.'}}</p>
                        <hr class="mb-8 mt-4">
                        <div class="grid grid-cols-2 gap-4">
                            @if(!$validDynamicKey)
                                <div class="mx-auto w-[30rem] col-span-2">
                                    <div class="relative w-full ">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6 text-violet-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                                          d="M21 16.42V19.9561C21 20.4811 20.5941 20.9167 20.0705 20.9537C19.6331 20.9846 19.2763 21 19 21C10.1634 21 3 13.8366 3 5C3 4.72371 3.01545 4.36687 3.04635 3.9295C3.08337 3.40588 3.51894 3 4.04386 3H7.5801C7.83678 3 8.05176 3.19442 8.07753 3.4498C8.10067 3.67907 8.12218 3.86314 8.14207 4.00202C8.34435 5.41472 8.75753 6.75936 9.3487 8.00303C9.44359 8.20265 9.38171 8.44159 9.20185 8.57006L7.04355 10.1118C8.35752 13.1811 10.8189 15.6425 13.8882 16.9565L15.4271 14.8019C15.5572 14.6199 15.799 14.5573 16.001 14.6532C17.2446 15.2439 18.5891 15.6566 20.0016 15.8584C20.1396 15.8782 20.3225 15.8995 20.5502 15.9225C20.8056 15.9483 21 16.1633 21 16.42Z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input
                                                type="tel"
                                                wire:model.live="cardNumber"
                                                maxlength="10"
                                                pattern="\d{10}"
                                                placeholder="Phone Number"
                                                class="block w-full pl-9 pr-8 h-[3rem] border-1 border-violet-500 rounded-lg text-violet-700 placeholder-violet-400
                                               bg-violet-50 focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent
                                               transition duration-150 ease-in-out
                                               text-base font-normal
                                               shadow-lg hover:shadow-md focus:shadow-lg">
                                        </div>
                                    </div>
                                    <div class="relative w-full mt-4">
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                                <svg class="size-6 text-violet-500" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="1.7"
                                                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <input
                                                type="number"
                                                wire:model.live="moneyQty"
                                                placeholder="Amount..."
                                                class="block w-full pl-9 pr-8 h-[3rem] border-1 border-violet-500 rounded-lg text-violet-700 placeholder-violet-400
                                                   bg-violet-50 focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent
                                                   transition duration-150 ease-in-out
                                                   text-base font-normal
                                                   shadow-lg hover:shadow-md focus:shadow-lg">
                                        </div>
                                    </div>
                                    <x-button wire:click="openWithdrawalModal" class="h-[2.2rem] mt-6">
                                        Withdraw
                                    </x-button>
                                    @error('openModal')
                                    <div class="flex mb-[-20px] mt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" color="red" viewBox="0 0 24 24"
                                             fill="currentColor">
                                            <path
                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path>
                                        </svg>
                                        <span class="text-red-500 text-sm ml-1 mt-1">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>
                            @else
                                @php
                                    $validCards = $phoneCards->filter(function($card) {
                                        return str_starts_with($card->card_number, '0');
                                    });
                                @endphp

                                @if($phoneCards->isEmpty() || $validCards->isEmpty())
                                    <p class="mt-1 text-violet-500 leading-relaxed text-base font-semibold">
                                        We not found valid cards 😔
                                    </p>
                                @else
                                    @foreach($validCards as $card)
                                        <div class="col-span-2 md:col-span-1">
                                            <x-secondary-button
                                                class="mb-4 w-full h-16 text-xs md:text-sm flex justify-between
                                                {{ $selectedCard?->card_number === $card->card_number ?
                                                    'bg-gradient-to-r from-violet-400 to-violet-900 text-white hover:bg-violet-700 focus:ring-violet-700' :
                                                     'bg-gradient-to-r from-violet-50 to-violet-100' }}"
                                                wire:click="setSelectedCard('{{ $card->card_number }}')">
                                                <div>
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
                                                <div>
                                                    ${{ number_format($card->amount, 0, ',', '.') }}
                                                </div>
                                            </x-secondary-button>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="mt-2 col-span-1 md:col-span-2">
                                    {{ $phoneCards->links() }}
                                </div>
                                <div class="mt-4 col-span-2 md:col-span-1">
                                    <div class="flex justify-center">
                                        <x-button wire:click="openWithdrawalModal" class="h-[2.2rem]">
                                            Withdraw
                                        </x-button>
                                        @if($validDynamicKey)
                                            {{-- Input --}}
                                            <div class="relative w-full ml-4">
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                                        <svg class="size-6 text-violet-500" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="1.7"
                                                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                    <input
                                                        type="number"
                                                        wire:model.live="moneyQty"
                                                        placeholder="Amount..."
                                                        class="block w-full pl-9 pr-8 h-[2.2rem] border-1 border-violet-500 rounded-lg text-violet-700 placeholder-violet-400
                                                   bg-violet-50 focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent
                                                   transition duration-150 ease-in-out
                                                   text-base font-normal
                                                   shadow-lg hover:shadow-md focus:shadow-lg">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @error('openModal')
                                    <div class="flex mb-[-20px] mt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" color="red" viewBox="0 0 24 24"
                                             fill="currentColor">
                                            <path
                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path>
                                        </svg>
                                        <span class="text-red-500 text-sm ml-1">{{ $message }}</span>
                                    </div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

    @elseif($success)

        <!-- Success Menu -->

        <div class="gap-4 mx-4 sm:mx-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:col-span-2 col-span-1 mb-4">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class=" text-2xl font-medium text-gray-900">
                        Withdraw Success!
                    </h1>
                    <div class="flex mt-4">
                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor">
                            <path
                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z"></path>
                        </svg>
                        <p class="text-gray-700 leading-relaxed ml-2">
                            You will be redirected after <span class="font-bold text-red-600">1 minute.</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:col-span-2 col-span-1">

                <!-- Success Withdraw Toast Message -->

                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     class="fixed bottom-4 right-4 bg-green-400 text-white p-4 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"></path>
                        </svg>
                        <h1 class="text-lg font-semibold">
                            Withdraw Successfully!
                        </h1>
                    </div>
                </div>

                <!-- Withdraw Details -->

                <div class="p-6 lg:p-8 bg-white border-b border-gray-200 shadow-sm rounded-lg">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-4">
                        Withdraw Details
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24"
                                 fill="currentColor">
                                <path
                                    d="M22.0049 6.99979H23.0049V16.9998H22.0049V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V6.99979ZM20.0049 16.9998H14.0049C11.2435 16.9998 9.00488 14.7612 9.00488 11.9998C9.00488 9.23836 11.2435 6.99979 14.0049 6.99979H20.0049V4.99979H4.00488V18.9998H20.0049V16.9998ZM21.0049 14.9998V8.99979H14.0049C12.348 8.99979 11.0049 10.3429 11.0049 11.9998C11.0049 13.6566 12.348 14.9998 14.0049 14.9998H21.0049ZM14.0049 10.9998H17.0049V12.9998H14.0049V10.9998Z"></path>
                            </svg>
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
                            @if(isset($data['denominationsCounts']))
                                <div class="mt-4">
                                    <strong class="text-gray-700">Denominations:</strong>
                                    <div class="space-y-2 mt-2">

                                        @foreach($data['denominationsCounts']['denominations'] as $index => $denomination)
                                            <div
                                                class="flex items-center p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                                <!-- Icon -->
                                                <div class="flex-shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6"
                                                         viewBox="0 0 24 24" fill="currentColor">
                                                        <path
                                                            d="M12.0004 16C14.2095 16 16.0004 14.2091 16.0004 12 16.0004 9.79086 14.2095 8 12.0004 8 9.79123 8 8.00037 9.79086 8.00037 12 8.00037 14.2091 9.79123 16 12.0004 16ZM21.0049 4.00293H3.00488C2.4526 4.00293 2.00488 4.45064 2.00488 5.00293V19.0029C2.00488 19.5552 2.4526 20.0029 3.00488 20.0029H21.0049C21.5572 20.0029 22.0049 19.5552 22.0049 19.0029V5.00293C22.0049 4.45064 21.5572 4.00293 21.0049 4.00293ZM4.00488 15.6463V8.35371C5.13065 8.017 6.01836 7.12892 6.35455 6.00293H17.6462C17.9833 7.13193 18.8748 8.02175 20.0049 8.3564V15.6436C18.8729 15.9788 17.9802 16.8711 17.6444 18.0029H6.3563C6.02144 16.8742 5.13261 15.9836 4.00488 15.6463Z"></path>
                                                    </svg>
                                                </div>
                                                <!-- Text -->
                                                <div class="ml-3">
                                                    <p class="text-gray-800 text-lg font-bold">
                                                        ${{ number_format($denomination, 2) }}</p>
                                                    <p class="text-gray-600">Quantity:
                                                        <span
                                                            class="font-medium">{{ $data['denominationsCounts']['counts'][$index] }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
