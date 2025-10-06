<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{___('Add Plan')}}</h2>
            </div>
            <div class="slidePanel-actions">
                <button id="post_sidePanel_data" class="btn btn-icon btn-primary" title="{{___('Save')}}">
                    <i class="icon-feather-check"></i>
                </button>
                <button class="btn btn-icon btn-default slidePanel-close" title="{{___('Close')}}">
                    <i class="icon-feather-x"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="slidePanel-inner">
        <form action="{{ route('admin.plans.store') }}" method="post" enctype="multipart/form-data" id="sidePanel_form">
            @csrf
            <div class="mb-3 form-group">
                <label class="d-flex align-items-end m-b-5" for="name">
                    {{ ___('Plan Name') }} *
                    <div class="d-flex align-items-center translate-picker">
                        <i class="fa fa-language"></i>
                        <select class="custom-select custom-select-sm ml-1">
                            <option value="default">{{ ___('Default') }}</option>
                            @foreach ($admin_languages as $language)
                                <option value="{{ $language->code }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </label>
                <div class="translate-fields translate-fields-default">
                    <input name="name" id="name" type="text" class="form-control" required value="" autofocus>
                </div>
                @foreach ($admin_languages as $language)
                    <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                        <input type="text" class="form-control" name="translations[{{ $language->code }}][name]">
                    </div>
                @endforeach
            </div>
            <div class="mb-3 form-group">
                <label class="d-flex align-items-end m-b-5">
                    {{ ___('Description') }}
                    <div class="d-flex align-items-center translate-picker">
                        <i class="fa fa-language"></i>
                        <select class="custom-select custom-select-sm ml-1">
                            <option value="default">{{ ___('Default') }}</option>
                            @foreach ($admin_languages as $language)
                                <option value="{{ $language->code }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </label>
                <div class="translate-fields translate-fields-default">
                    <textarea name="description" class="form-control"></textarea>
                </div>
                @foreach ($admin_languages as $language)
                    <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                        <textarea name="translations[{{ $language->code }}][description]" class="form-control"></textarea>
                    </div>
                @endforeach
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Status') }} *</label>
                <select class="form-select" name="status">
                    <option value="1">{{ ___('Active') }}</option>
                    <option value="0">{{ ___('Inactive') }}</option>
                    <option value="2">{{ ___('Hidden') }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Monthly Price') }} *</label>
                <div class="custom-input-group input-group">
                    <input type="text" name="monthly_price" class="form-control"
                           value="0" required/>
                    <span class="input-group-text"><strong>{{ $settings->currency_code }}</strong></span>
                </div>
                <small class="form-text">{{ ___('Set 0 to disable it.') }}</small>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Annual Price') }} *</label>
                <div class="custom-input-group input-group">
                    <input type="text" name="annual_price" class="form-control"
                           value="0" required/>
                    <span class="input-group-text"><strong>{{ $settings->currency_code }}</strong></span>
                </div>
                <small class="form-text">{{ ___('Set 0 to disable it.') }}</small>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Lifetime Price') }} *</label>
                <div class="custom-input-group input-group">
                    <input type="text" name="lifetime_price" class="form-control"
                           value="0" required/>
                    <span class="input-group-text"><strong>{{ $settings->currency_code }}</strong></span>
                </div>
                <small class="form-text">{{ ___('Set 0 to disable it.') }}</small>
            </div>
            <div class="mb-3">
                {{ quick_switch(___('Recommended'), 'recommended') }}
            </div>
            <h5 class="m-t-35">{{ ___('Plan Settings') }}</h5>
            <hr>
            <div class="mb-3">
                <label class="form-label" for="ad_limit">{{ ___('Listing Post Limit') }} *</label>
                <input name="ad_limit" type="number" class="form-control" id="ad_limit" value="10" min="1" max="3">
                <span class="form-text text-muted">{{ ___('For unlimited, enter 999.') }}</span>
            </div>
            <div class="mb-3">
                <label class="form-label" for="ad_duration">{{ ___('Post Duration in Days') }} *</label>
                <input name="ad_duration" type="number" class="form-control" id="ad_duration" value="3" min="1" max="3">
            </div>
            <div class="mb-3">
                <label class="form-label" for="featured_project_fee">{{ ___('Featured Fee') }} *</label>
                <input name="featured_project_fee" type="number" class="form-control" id="featured_project_fee" value="10">
            </div>
            <div class="mb-3">
                <label class="form-label" for="urgent_project_fee">{{ ___('Urgent Fee') }} *</label>
                <input name="urgent_project_fee" type="number" class="form-control" id="urgent_project_fee" value="10">
            </div>
            <div class="mb-3">
                <label class="form-label" for="highlight_project_fee">{{ ___('Highlight Fee') }} *</label>
                <input name="highlight_project_fee" type="number" class="form-control" id="highlight_project_fee" value="10">
            </div>

            <h5 class="m-t-35">{{ ___('Package Option (Check it if you want to allow)') }}</h5>
            <hr>
            <div class="mb-3">
                <div class="checkbox">
                    <input type="checkbox" name="top_search_result" id="top_search_result" value="yes">
                    <label for="top_search_result"><span class="checkbox-icon"></span> {{ ___('Top in search results and category.') }}</label>
                </div>
            </div>
            <div class="mb-3">
                <div class="checkbox">
                    <input type="checkbox" name="show_on_home" id="show_on_home" value="yes">
                    <label for="show_on_home"><span class="checkbox-icon"></span> {{ ___('Show ad on home page premium ad section.') }}</label>
                </div>
            </div>

            <div class="mb-3">
                {{ quick_switch(___('Hide Branding'), 'hide_branding', true) }}
            </div>
            <div class="mb-3">
                {{ quick_switch(___('Show advertisements'), 'advertisements') }}
            </div>

            @if($PlanOption->count())
                <h5 class="m-t-35">{{ ___('Custom Settings') }}</h5>
                <hr>
                @foreach ($PlanOption as $planoption)
                    <div class="mb-3">
                        {{quick_switch($planoption['title'], "planoptions[{$planoption['id']}]")}}
                    </div>
                @endforeach
            @endif

            @if($taxes->count())
            <h5 class="m-t-35">{{ ___('Taxes') }}</h5>
            <hr>
            <div class="mb-3">
                <label class="form-label">{{ ___('Select Taxes') }}</label>
                <select class="form-control select2" name="taxes[]" multiple>
                    @foreach ($taxes as $tax)
                        @php
                            $value = ($tax->value_type == 'percentage' ? (float) $tax->value .'%' : price_format($tax->value));
                        @endphp

                        <option value="{{ $tax->id }}">{{ $tax->name }} ({{ $value }})</option>

                    @endforeach
                </select>
                <span class="form-text text-muted">{{ ___('Select taxes for this plan.') }}</span>
            </div>
            @endif
        </form>
    </div>
</div>
<script src="{{ asset('admin/assets/js/quicklara.js') }}"></script>
