@props(["name", "values"])

<span x-data='{ selected: undefined }' {{ $attributes->only(["x-model"]) }} x-modelable="selected">
    <input type="radio" @click="selected = undefined" :checked="selected === undefined" aria-label="All" class="checked:btn-info btn mb-1 mr-1 rounded-md" />
    @foreach ($values as $key => $value)
        <input type="radio" @click="selected = '{{ $key }}'" :checked="selected === '{{ $key }}'" aria-label="{{ $value }}"
            class="checked:btn-info btn mb-1 mr-1 rounded-md" />
    @endforeach
</span>
