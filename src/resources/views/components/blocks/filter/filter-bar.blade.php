<?php

use Livewire\Component;

new class extends Component {
    /**
     * @var array<string, array{
     *     label: string,
     *     values: array<int|string, string>,
     *     component: string
     * }>
     */
    public array $filterSchemes;

    public bool $includeResetBtns = false;
};
?>

<div x-data="{
    filters: {},

    activeFilters() {
        let result = [];

        const schemes = this.$wire.filterSchemes;

        for (const name of Object.keys(schemes)) {

            const value = this.filters[name];

            if (value === undefined) continue;

            const schema = schemes[name];

            if (Array.isArray(value)) {

                for (const item of value) {
                    result.push({
                        name,
                        value: item,
                        label: schema.values[item],
                        resetCallback: () => {
                            const active = this.filters[name].filter(v => v !== item);
                            active.length === 0 ?
                                this.filters[name] = undefined :
                                this.filters[name] = active;
                        }
                    });
                }
            } else {
                result.push({
                    name,
                    value,
                    label: schema.values[value],
                    resetCallback: () => {
                        this.filters[name] = undefined;
                    }
                });
            }
        }

        return result;
    }
}" x-init="$watch('filters', (value) => $dispatch('filters-updated', { filters: value }))" class="mb-4">

    @foreach ($filterSchemes as $name => $schema)
        <x-dynamic-component :component='$schema["component"]' :name='$name' :label='$schema["label"]' :values='$schema["values"]' x-model="filters['{{ $name }}']" />
    @endforeach

    @if ($includeResetBtns)
        <div class="mt-2">
            <template x-for="filter in activeFilters()" :key="filter.name + '-' + filter.value">
                <span class="badge badge-soft mr-1 select-none">
                    <span x-text="filter.label"></span>
                    <button class="cursor-pointer" @click="filter.resetCallback()" type="button">✕</button>
                </span>
            </template>
            <template x-if="JSON.stringify(filters) !== '{}'">
                <button type="button" class="text-info ml-1 cursor-pointer" @click="filters = {}">
                    Clear filters
                </button>
            </template>
        </div>
    @endif
</div>
