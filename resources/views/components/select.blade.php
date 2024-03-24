
<select {{ $attributes->except(['value', 'default', 'disabledIf']) }} {{ $attributes->get('disable-if') ? 'disabled' : '' }}>
    @foreach ($attributes->get('value') as $val)
        <option value="{{ $val }}" {{ $attributes->get('default') == $val ? 'selected' : '' }}>{{ $val }}</option>
    @endforeach
</select>