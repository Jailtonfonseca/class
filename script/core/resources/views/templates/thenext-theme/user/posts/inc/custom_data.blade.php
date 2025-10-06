@if($post->custom_field_data->count() > 0)
    @foreach ($post->custom_field_data as $customdata)
        @if($customdata->active && $customdata->show_in_view)
            <div class="d-flex align-items-center fs-sm gap-1 me-1 text-body">
                @if($customdata->type == 'drop-down' || $customdata->type == 'radio-buttons')
                    @php
                        $option = get_customOptions_by_id($customdata->pivot->field_data);
                    @endphp
                    @if($option)
                        <span class="d-flex align-items-center fs-sm gap-1">
                            @if(Str::isUrl($customdata->icon))
                                <img src="{{ $customdata->icon }}" width="18" title="{{ $customdata->title }}" alt="{{ $customdata->title }}"/>
                            @else
                                <i class="{{ $customdata->icon }} me-1 fs-lg text-muted"></i>
                            @endif
                            {{ $option->title }}
                        </span>
                    @endif
                @elseif($customdata->type == 'text-field')
                    <span class="d-flex align-items-center fs-sm gap-1">
                        @if(Str::isUrl($customdata->icon))
                            <img src="{{ $customdata->icon }}" width="18" title="{{ $customdata->title }}" alt="{{ $customdata->title }}"/>
                        @else
                            <i class="{{ $customdata->icon }} me-1 fs-lg text-muted"></i>
                        @endif
                        {{ $customdata->pivot->field_data }}
                    </span>
                @endif
            </div>
        @endif
    @endforeach
@endif
