<div class="max-w-7xl mx-auto">
    <div class="sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-4">
            <div class="p-6 lg:p-8 bg-white border-b border-gray-200 overflow-hidden shadow-xl sm:rounded-lg mx-4 sm:mx-0 col-span-2">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight mb-6">
                    Add New Card
                </h2>

                <form wire:submit="submit" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6 md:grid-cols-1">
                        <div class="relative">
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Card Type</label>
                            <select wire:model="type" id="type" class="block w-full px-4 py-3 rounded-md border-2 border-violet-300 bg-white text-gray-800 shadow-sm focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50 transition duration-150 ease-in-out appearance-none">
                                <option value="phone">Phone Number</option>
                                <option value="bank">Bank Account</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                        <div>
                            <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $type === 'phone' ? 'Phone Number' : 'Account Number' }}
                            </label>
                            <input
                                wire:model="card_number"
                                type="text"
                                id="card_number"
                                class="block w-full px-4 py-3 rounded-md border-2 border-violet-300 bg-white text-gray-800 shadow-sm focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50 transition duration-150 ease-in-out"
                                maxlength="{{ $type === 'phone' ? '10' : '11' }}"
                                placeholder="{{ $type === 'phone' ? 'E.g., 9876543210' : 'E.g., 12345678901' }}"
                            >
                            @error('card_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6 md:grid-cols-1">
                        <div>
                            <label for="pin" class="block text-sm font-medium text-gray-700 mb-1">PIN</label>
                            <input wire:model="pin" type="password" id="pin_" maxlength="4" class="block w-full px-4 py-3 rounded-md border-2 border-violet-300 bg-white text-gray-800 shadow-sm focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50 transition duration-150 ease-in-out" placeholder="Enter PIN">
                            @error('pin') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
                                    $
                                </span>
                                <input wire:model="amount" type="number" id="amount" step="0.01" class="block w-full pl-7 pr-4 py-3 rounded-md border-2 border-violet-300 bg-white text-gray-800 shadow-sm focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50 transition duration-150 ease-in-out" placeholder="E.g., 100.00">
                            </div>
                            @error('amount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea wire:model="description" id="description" rows="3" class="block w-full px-4 py-3 rounded-md border-2 border-violet-300 bg-white text-gray-800 shadow-sm focus:border-violet-500 focus:ring focus:ring-violet-200 focus:ring-opacity-50 transition duration-150 ease-in-out" placeholder="Enter an optional description"></textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <button type="submit" class="w-full py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 transition duration-150 ease-in-out transform hover:scale-105">
                            Register Card
                        </button>
                    </div>
                </form>
                @if (session()->has('message'))
                    <div class="mt-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
