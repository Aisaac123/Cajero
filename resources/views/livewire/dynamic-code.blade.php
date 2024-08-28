<div>
    <div x-data="{
                init() {
                    setInterval(() => {
                        this.$wire.decrementTimeLeft();
                    }, 250);
                }
            }" x-init="init">

        <template x-if="isValidKey">
            @if(auth()->user()->two_factor_confirmed_at)
                <div class="flex justify-end sm:mb-[-15px] mt-[-8px] sm:mt-0">
                    <h2 class="text-lg font-bold text-center text-gray-800"></h2>
                    <div class="flex">
                        <div class="flex-col flex mt-[-8px] hidden sm:block border-r-[0.17rem] mr-3 border-violet-500">
                            <div class="text-sm font-bold tracking-widest pr-3">
                                Transactional
                            </div>
                            <div class="text-sm font-bold tracking-widest pr-3 text-center">
                                Dynamic key
                            </div>
                        </div>

                        <div class="sm:mt-[-10px]">
                            <span class="text-lg font-bold tracking-widest text-violet-600">{{ $code }}</span>
                            <div class="flex mt-1">
                                <div class="flex justify-between w-full">
                                    <div id="progress-bar" class="relative h-1.5 bg-gray-200 rounded-full" style="width: calc(100%);">
                                        <div class="top-0 left-0 h-1.5 bg-violet-400 rounded-full transition-all duration-1000"
                                             style="width:{{ $timeLeft > 0 ? number_format(($timeLeft / $durationSeconds) * 100, 0) : 0 }}%">
                                        </div>
                                    </div>
                                    <div class="text-xs font-bold text-end items-end tracking-widest text-violet-500 mt-[-0.36rem] w-4" style="width: 45px;">
                                        {{ number_format(($timeLeft / $toSecondMultiplier), 0) > 0 ? number_format(($timeLeft / $toSecondMultiplier), 0) : 0 }}s
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </template>
    </div>
</div>
