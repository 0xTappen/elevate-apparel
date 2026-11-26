@props(['name', 'label', 'options', 'selected' => '', 'id' => null])
@php($fieldId = $id ?? $name)
<div class="relative" data-custom-select>
    <label class="label" id="{{ $fieldId }}-label">{{ $label }}</label>
    <input type="hidden" name="{{ $name }}" value="{{ $selected }}" data-select-input>
    <button type="button" class="field flex items-center justify-between gap-3 text-left shadow-[4px_4px_0_#d4f541] transition-colors hover:bg-lime focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ink" aria-labelledby="{{ $fieldId }}-label {{ $fieldId }}-value" aria-haspopup="listbox" aria-expanded="false" aria-controls="{{ $fieldId }}-options" data-select-trigger>
        <span id="{{ $fieldId }}-value" data-select-label>{{ $options[(string) $selected] ?? reset($options) }}</span>
        <svg class="h-4 w-4 shrink-0" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="m2 5 6 6 6-6" stroke="currentColor" stroke-width="2"/></svg>
    </button>
    <div id="{{ $fieldId }}-options" role="listbox" aria-labelledby="{{ $fieldId }}-label" class="absolute z-30 mt-2 hidden max-h-64 w-full overflow-y-auto border-2 border-ink bg-white p-1 shadow-[6px_6px_0_#141414]" data-select-menu>
        @foreach ($options as $value => $text)
            <button type="button" role="option" aria-selected="{{ (string) $selected === (string) $value ? 'true' : 'false' }}" data-select-option data-value="{{ $value }}" class="flex min-h-11 w-full items-center justify-between gap-2 px-3 py-2 text-left text-sm font-semibold transition-colors hover:bg-lime focus:bg-lime focus:outline-none aria-selected:bg-ink aria-selected:text-lime">
                <span>{{ $text }}</span><span aria-hidden="true" data-select-check>{{ (string) $selected === (string) $value ? '✓' : '' }}</span>
            </button>
        @endforeach
    </div>
</div>
