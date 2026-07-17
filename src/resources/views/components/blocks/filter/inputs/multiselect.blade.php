@props(["label", "values"])

<div x-data='{
            open: false,
            selected: undefined,

            toggle(value) {
                let temp = Array.isArray(this.selected)
                    ? [...this.selected]
                    : [];

                if (temp.includes(value)) {
                    temp = temp.filter(v => v !== value);
                } else {
                    temp.push(value);
                }

                this.selected = temp.length ? temp : undefined;
            }
        }'
    {{ $attributes->only(["x-model"]) }} x-modelable="selected" @click.outside="open = false" class="dropdown" :class="open ? `dropdown-open` : `dropdown-close`">
    <div @click="open = !open" class="border-neutral text-base-content mb-1 mr-1 select-none rounded-md border-2 px-4 py-1.5">
        <span class="mr-1">
            {{ $label }}
        </span>
        <x-assets.ui.chevron-down x-show="!open" />
        <x-assets.ui.chevron-up x-show="open" x-cloak="!open" />
    </div>
    <ul class="dropdown-content menu bg-base-100 rounded-box z-1 w-48 rounded-sm p-2 shadow-sm">
        @foreach ($values as $key => $value)
            <li>
                <a @click="open = false; toggle('{{ $key }}')" class="rounded-sm">
                    <input :checked="selected?.includes('{{ $key }}')" type="checkbox" class="checkbox" />
                    <label>
                        {{ $value }}
                    </label>
                </a>
            </li>
        @endforeach
    </ul>
</div>
