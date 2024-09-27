@props([
    'disabled' => false,
    'defaultOption' => 'Select Item',
    'options' => [],
    'selected' => null,
    'labelField' => 'name',
    'valueField' => 'id',
])

@php
    $options = $options->map(function ($item) use ($labelField, $valueField){
        return (object)[
            'label' => $item->$labelField,
            'value' => $item->$valueField
        ];
    });
@endphp

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    <option value="">{{ $defaultOption }}</option>
    @foreach($options as $option)
        <option
            value="{{ $option->value }}"
            {{ $option->value == $selected ? 'selected' : '' }}
        >
            {{ $option->label }}
        </option>
    @endforeach
</select>
