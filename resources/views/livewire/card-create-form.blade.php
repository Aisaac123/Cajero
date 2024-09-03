<div class="max-w-5xl mx-auto">
    <div class="sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-4">
            <div class="p-6 lg:p-8 bg-white border-b border-gray-200 overflow-hidden shadow-xl sm:rounded-lg mx-4 sm:mx-0 col-span-2">
                <div class="flex justify-between">
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                        Add New Card
                    </h2>
                    <div>
                        <x-button form="card-create-form" type="submit" class="sm:block hidden hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition duration-150 ease-in-out transform hover:scale-105">
                            ADD CARD
                        </x-button>
                        <x-button form="card-create-form" type="submit" class="sm:hidden block hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition duration-150 ease-in-out transform hover:scale-105">
                            ADD
                        </x-button>
                    </div>
                </div>
                <div class="mb-3">
                    @error('card_number')
                    <div class="flex mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="red"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path></svg>
                        <span class="text-red-500 ml-2">{{ $message }}</span>
                    </div>
                    @enderror
                    @error('amount')
                    <div class="flex mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="red"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path></svg>
                        <span class="text-red-500 ml-2">{{ $message }}</span>
                    </div>
                    @enderror
                    @error('pin')
                    <div class="flex mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="red"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path></svg>
                        <span class="text-red-500 ml-2">{{ $message }}</span>
                    </div>
                    @enderror
                    @error('description')
                    <div class="flex mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="red"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z"></path></svg>
                        <span class="text-red-500 ml-2">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
                <form id="card-create-form" wire:submit="submit" class="space-y-6 bg-gradient-to-tl from-violet-400 to-violet-700 p-8 border border-violet-900 rounded-lg">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="relative col-span-2 md:col-span-1 ">
                            <label for="type" class="block text-base font-medium mb-1 text-white">Card Type</label>
                            <select wire:model.live.debounce.1ms="type" id="type" class=" block w-full px-4 py-3 rounded-md border-2 border-violet-400 bg-white text-gray-800 shadow-sm focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50 transition duration-150 ease-in-out appearance-none">
                                <option value="{{ 'phone' }}">Phone Number</option>
                                <option value="{{ 'card' }}">Card Number</option>
                            </select>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="card_number" class="block text-base font-medium text-white mb-1">
                                {{ $type === 'phone' ? 'Phone Number' : 'Card Number' }}
                            </label>
                            <input
                                wire:model="card_number"
                                type="text"
                                id="card_number"
                                class="block w-full px-4 py-3 rounded-md border-2 border-violet-400 bg-white text-gray-800 shadow-sm focus:border-violet-600 focus:ring focus:ring-violet-200 focus:ring-opacity-50 transition duration-150 ease-in-out"
                                maxlength="{{ $type === 'phone' ? '10' : '11' }}"
                                placeholder="{{ $type === 'phone' ? 'E.g., 3001234567' : 'E.g., 12345678901' }}"
                            >
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2 md:col-span-1">
                            <label for="pin" class="block text-base font-medium text-white mb-1">PIN</label>
                            <input wire:model="pin" type="password" id="pin_" maxlength="4"
                                   class="block w-full px-4 py-3 rounded-md border-2
                                   border-violet-400 text-gray-800 shadow-sm
                                   focus:border-violet-600 focus:ring focus:ring-violet-200
                                   focus:ring-opacity-50 transition duration-150 ease-in-out"
                                   placeholder="Enter PIN">
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="amount" class="block text-base font-medium text-white mb-1">Amount</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
                                    $
                                </span>
                                <input wire:model="amount" type="number" id="amount" step="0.01" class="block w-full pl-7 pr-4 py-3 rounded-md border-2 border-violet-400 bg-white text-gray-800 shadow-sm focus:border-violet-600 focus:ring focus:ring-violet-200 focus:ring-opacity-50 transition duration-150 ease-in-out" placeholder="E.g., 100.00">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-base font-medium text-white mb-1">Description</label>
                        <textarea wire:model="description" id="description" rows="3" class="block w-full px-4 py-3 rounded-md border-2 border-violet-400 bg-white text-gray-800 shadow-sm focus:border-violet-600 focus:ring focus:ring-violet-200 focus:ring-opacity-50 transition duration-150 ease-in-out" placeholder="Enter an optional description"></textarea>
                    </div>
                </form>
                @if (session()->has('message'))
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
                                Card created successfully!
                            </h1>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
