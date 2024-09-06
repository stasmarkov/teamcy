@props([
  'type' => 'text',
  'label' => '',
  'required' => 'true',
  'placeholder' => '',
  'martingTop' => TRUE,
])

<div class="{{ $attributes->merge(['class' => ''])->get('class') }}">
  @if ($label)
    <label
      for="{{ $attributes->whereStartsWith('wire:model')->first() }}"
      class="block text-sm font-medium text-gray-700 leading-5"
    >
      {{ $label }}
    </label>
  @endif

  <div class="mt-1 rounded-md shadow-sm">
    <input
      {{ $attributes->whereStartsWith('wire:model') }}
      id="{{ $attributes->whereStartsWith('wire:model')->first() }}"
      type="{{ $type }}"
      required="{{ $required }}"
      placeholder="{{ $placeholder }}"
      autofocus
      class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error($attributes->whereStartsWith('wire:model')->first()) border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror"
      @error($attributes->whereStartsWith('wire:model')->first())
      aria-invalid="true"
      aria-describedby="{{ $attributes->whereStartsWith('wire:model')->first() }}-error"
      @enderror
    />
  </div>

  @error($attributes->whereStartsWith('wire:model')->first())
  <p
    wire:key="error_{{ $attributes->whereStartsWith('wire:model')->first() }}"
    class="mt-2 text-sm text-red-600"
  >
    {{ $message }}
  </p>
  @enderror
</div>
