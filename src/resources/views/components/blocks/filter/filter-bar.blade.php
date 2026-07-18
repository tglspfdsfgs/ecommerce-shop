<?php

use App\Shared\Filters\FilterInputType;
use Livewire\Component;

new class extends Component {
    public array $filterSchemes;

    public bool $includeResetBtns = false;

    public function filterComponent(FilterInputType $input): string
    {
        return match ($input) {
            FilterInputType::Select => "blocks.filter.inputs.select",
            FilterInputType::MultiSelect => "blocks.filter.inputs.multiselect",
            FilterInputType::Radio => "blocks.filter.inputs.radio",
        };
    }
};
?>

<div x-data="{
    filters: {},

    init() {
        this.$watch('filters', (value) => $dispatch('filters-updated', { filters: value }));
    }
}" class="mb-4">

    @foreach ($filterSchemes as $schema)
        {{-- prettier-ignore --}}
        <x-dynamic-component x-model="filters['{{ $schema['filter'] }}']" :component="$this->filterComponent($schema['input'])" :label='$schema["label"]' :values='$schema["values"]' />
    @endforeach

    @if ($includeResetBtns)
        <div x-data="{
            filterOptions(filter) {
                    const schemes = this.$wire.filterSchemes.filter(
                        (schema) => schema.filter === filter
                    );
        
                    return Object.assign({},
                        ...schemes.map((schema) => schema.values)
                    );
                },
        
                activeFilters() {
                    let result = [];
        
                    for (const filter in filters) {
        
                        const value = filters[filter];
        
                        if (value == null) continue;
        
                        if (Array.isArray(value)) {
                            const options = this.filterOptions(filter);
        
                            for (const item of value) {
                                result.push({
                                    key: filter + item,
                                    label: options[item],
                                    resetCallback: () => {
                                        const active = filters[filter].filter(v => v !== item);
                                        active.length === 0 ?
                                            delete filters[filter] :
                                            filters[filter] = active;
                                    }
                                });
                            }
                        } else {
                            const options = this.filterOptions(filter);
        
                            result.push({
                                key: filter + value,
                                label: options[value],
                                resetCallback: () => {
                                    delete filters[filter];
                                }
                            });
                        }
                    }
        
                    return result;
                }
        }" class="mt-2">
            <template x-for="filter in activeFilters()" :key="filter.key">
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
    <div x-text="JSON.stringify(filters)"></div>
</div>
