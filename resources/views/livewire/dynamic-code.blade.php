<div
    x-data="{
        init() {
            setInterval(() => {
                this.$wire.decrementTimeLeft()
            }, 250)
        }
    }"
    x-init="init">
    <div class="flex justify-end sm:mb-[-15px] mt-[-14px] sm:mt-0">
        <h2 class="text-lg font-bold text-center text-gray-800"></h2>
        <div class="flex">
            <div class="text-lg font-bold tracking-widest pr-3 hidden sm:block">
                Clave Dinámica:
            </div>
            <div class="sm:mt-[-15px]">
                <span class="text-xl font-bold tracking-widest text-violet-600">{{ $code }}</span>
                <div class="relative w-full h-2 bg-gray-200 rounded-full flex">
                    <div class="absolute top-0 left-0 h-2 bg-violet-400 rounded-full transition-all duration-1000"
                         style="width:{{ number_format(($timeLeft / $durationSeconds) * 100, 0) }}%">
                    </div>
                </div>
                <div class="text-sm font-bold text-center items-center tracking-widest text-violet-500 mt-[2px] mb-[-14px]">
                    {{ number_format(($timeLeft / $toSecondMultiplier), 0) }}s
                </div>
            </div>
        </div>
    </div>
</div>
