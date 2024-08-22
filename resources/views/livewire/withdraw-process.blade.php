<div>
    @if(!$passwordConfirmed)
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200 mx-4 sm:mx-0">
            <h1 class=" text-2xl font-medium text-gray-900">
                You are about to start the process of withdrawing.
            </h1>

            <p class="mt-4 text-gray-500 leading-relaxed">
                You are about to start the process of withdrawing money.
            </p>
            <p class="text-gray-500 leading-relaxed">
                The process below is completely secure under the privacy policy guidelines. The information to be displayed is sensitive information, please do not reveal your personal information to other people.
            </p>

            <x-confirms-password wire:then="confirmed">
                <x-button class="mt-6" wire:loading.attr="disabled">
                    Start
                </x-button>
            </x-confirms-password>
        </div>

    @else

        <div class="lg:grid-cols-2 grid-cols-1 grid gap-4 mx-4 sm:mx-0">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:col-span-2 col-span-1">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class=" text-2xl font-medium text-gray-900">
                        Withdraw Process
                    </h1>
                    <p class="mt-4 text-gray-500 leading-relaxed">
                        The withdrawal process involves securely accessing your bank account, selecting the desired amount, and confirming the transaction. Please ensure your personal information is protected throughout this process.
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white">
                    <h1 class="text-xl font-medium text-gray-900">
                        Select an ammount
                    </h1>
                    <p class="mt-1 text-gray-500 leading-relaxed">
                        Please select the desired amount of money to proceed.
                    </p>
                    <hr class="mb-4 mt-4">

                    <div class="grid lg:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40">
                        <x-secondary-button class="mt-4 w-full border-b-blue-200 text-xs md:text-sm {{ $moneyQty === 20000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}" wire:click="setMoneyQty(20000)">
                            $20.000
                        </x-secondary-button>
                        <x-secondary-button class="mt-4 w-full border-b-blue-200 text-xs md:text-sm {{ $moneyQty === 50000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}" wire:click="setMoneyQty(50000)">
                            $50.000
                        </x-secondary-button>
                    </div>
                    <div class="grid lg:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40">
                        <x-secondary-button class="mt-4 w-full border-b-blue-200 text-xs md:text-sm {{ $moneyQty === 100000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}" wire:click="setMoneyQty(100000)">
                            $100.000
                        </x-secondary-button>
                        <x-secondary-button class="mt-4 w-full border-b-blue-200 text-xs md:text-sm {{ $moneyQty === 200000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}" wire:click="setMoneyQty(200000)">
                            $200.000
                        </x-secondary-button>
                    </div>
                    <div class="grid lg:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40">
                        <x-secondary-button class="mt-4 w-full border-b-blue-200 text-xs md:text-sm {{ $moneyQty === 300000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}" wire:click="setMoneyQty(300000)">
                            $300.000
                        </x-secondary-button>
                        <x-secondary-button class="mt-4 w-full border-b-blue-200 text-xs md:text-sm {{ $moneyQty === 500000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}" wire:click="setMoneyQty(500000)">
                            $500.000
                        </x-secondary-button>
                    </div>
                    <div class="grid lg:grid-cols-2 grid-cols-1 xl:gap-x-52 lg:gap-x-40">
                        <x-secondary-button class="mt-4 w-full border-b-blue-200 text-xs md:text-sm {{ $moneyQty === 1000000 ? 'bg-violet-400 text-white hover:bg-violet-500 focus:ring-violet-700' : '' }}" wire:click="setMoneyQty(1000000)">
                            $1.000.000
                        </x-secondary-button>
                        <x-secondary-button class="mt-4 w-full border-b-blue-200 text-xs md:text-sm">
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
                    <hr class="mb-4 mt-4">
                </div>

            </div>
        </div>
    @endif
</div>
