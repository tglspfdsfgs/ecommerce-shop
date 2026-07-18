<?php

namespace App\Shared\Filters;

enum FilterInputType: string
{
    case Select = 'select';
    case MultiSelect = 'multiselect';
    case Radio = 'radio';
}
