<div
    x-data="{
        init() {
            setInterval(() => {
                this.$wire.decrementTimeLeft()
            }, 500)
        }
    }"
    x-init="init">
    <div class="flex justify-end">
        <h2 class="text-lg font-bold text-center text-gray-800"></h2>
        <div class="flex">
            <div class="text-lg sm:text-black text-white w-0 sm:w-fit font-bold tracking-widest pr-2">
                Clave Dinámica:
            </div>
            <div class="flex-col justify-end mt-[-5px]">
                <span class="text-xl font-bold tracking-widest text-violet-600">{{ $code }}</span>
                <div class="relative w-full h-2 bg-gray-200 rounded-full">
                    <div class="absolute top-0 left-0 h-2 bg-violet-400 rounded-full transition-all duration-1000"
                         style="width: {{ ($timeLeft / $maxTime) * 100 }}%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
