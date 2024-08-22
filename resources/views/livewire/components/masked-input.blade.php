<div x-data="{
    get maskedValue() {
        return '*'.repeat(this.$wire.modelValue.length);
    },
    isFocused: false
}">
    <input class="mt-1 block form-input w-full border-gray-300 rounded-md shadow-sm"
        type="password"
        wire:model.live="modelValue"
        maxlength="4"
        inputmode="numeric"
        pattern="[0-9]*"
        autocomplete="off"
        x-on:focus="isFocused = true"
        x-on:blur="isFocused = false"
        x-show="isFocused"
        x-ref="realInput"
    >
    <input class="mt-1 block form-input w-full border-gray-300 rounded-md shadow-sm"
        type="password"
        x-model="maskedValue"
        readonly
        x-show="!isFocused"
        x-on:click="isFocused = true; $nextTick(() => $refs.realInput.focus())"
    >
</div>
