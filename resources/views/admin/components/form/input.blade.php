@if (isset($label))
    @php
        $for_id = preg_replace('/[^A-Za-z0-9\-]/', '', strip_tags(Str::lower($label)));
    @endphp
    <label for="{{ $for_id ?? '' }}">{!! __($label) !!}</label>
@endif

<input type="{{ $type ?? 'text' }}" placeholder="{{ $placeholder ?? 'Type Here...' }}" name="{{ $name ?? '' }}"
    class="form--control {{ $class ?? '' }}" {{ $attribute ?? '' }} value="{{ $value ?? '' }}"
    @isset($data_limit)
     data-limit = {{ $data_limit }}
    @endisset
    @isset($required)
    required
@endisset
    @isset($readonly)
    readonly
@endisset>
