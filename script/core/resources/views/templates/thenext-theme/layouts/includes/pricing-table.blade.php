@if($plan->status == 1)
    <div class="pricing-plan {{ @$plan->recommended == "yes" ? 'recommended' : '' }}">

        @if (@$plan->recommended == "yes")
            <div class="recommended-badge">{{ ___('Recommended') }}</div>
        @endif

        <h3>{{ !empty($plan->translations->{get_lang()}->name)
                        ? $plan->translations->{get_lang()}->name
                        : $plan->name }}</h3>

        @if ($plan->id == 'free' || $plan->id == 'trial')
            <div class="pricing-plan-label">
                <strong>{{ $plan->id == 'free' ? ___('Free') : ___('Trial') }}</strong>
            </div>
        @else
            @if($total_monthly != 0)
                <div class="pricing-plan-label billed-monthly-label">
                    <strong>{{ price_symbol_format($plan->monthly_price) }}</strong>/ {{ ___('Monthly') }}
                </div>
            @endif

            @if($total_annual != 0)
                <div class="pricing-plan-label billed-yearly-label">
                    <strong>{{ price_symbol_format($plan->annual_price) }}</strong>/ {{ ___('Yearly') }}
                </div>
            @endif

            @if($total_lifetime != 0)
                <div class="pricing-plan-label billed-lifetime-label">
                    <strong>{{ price_symbol_format($plan->lifetime_price) }}</strong>/ {{ ___('Lifetime') }}
                </div>
            @endif

        @endif

        <div class="pricing-plan-features">
            <strong>{{ ___('Features of :plan_name', [ 'plan_name' => !empty($plan->translations->{get_lang()}->name)
                        ? $plan->translations->{get_lang()}->name
                        : $plan->name ]) }}</strong>
            <ul>
                <li>
                    {{ ___('Listing Post Limit') }}
                    {{ (@$plan->settings->ad_limit == 999 ? ___('Unlimited') : number_format(@$plan->settings->ad_limit)) }}
                </li>
                <li>
                    {{ ___('Listing expire in') }}
                    {{ (@$plan->settings->ad_duration == 999 ? ___('Unlimited') : number_format(@$plan->settings->ad_duration)) }}
                    {{ ___('Days') }}
                </li>

                <li>
                    {!! ___('Featured Listing fee')  !!}
                    <strong>{{ price_symbol_format(@$plan->settings->featured_project_fee) }}</strong>
                </li>
                <li>
                    {!! ___('Urgent Listing fee')  !!}
                    <strong>{{ price_symbol_format(@$plan->settings->urgent_project_fee) }}</strong>
                </li>
                <li>
                    {!! ___('Highlight Listing fee')  !!}
                    <strong>{{ price_symbol_format(@$plan->settings->highlight_project_fee) }}</strong>
                </li>
                <li>
                    @if (@$plan->settings->top_search_result)
                        <span class="icon-text yes text-success"><i class="icon-feather-check-circle margin-right-2"></i></span>
                    @else
                        <span class="icon-text no text-danger"><i class="icon-feather-x-circle margin-right-2"></i></span>
                    @endif
                    {{ ___('Show Listing top in search results') }}
                </li>
                <li>
                    @if (@$plan->settings->show_on_home)
                        <span class="icon-text yes text-success"><i class="icon-feather-check-circle margin-right-2"></i></span>
                    @else
                        <span class="icon-text no text-danger"><i class="icon-feather-x-circle margin-right-2"></i></span>
                    @endif
                    {{ ___('Show Listing on home page premium section') }}
                </li>

                <li>
                    @if (@$plan->settings->hide_branding)
                        <span class="icon-text yes"><i class="icon-feather-check-circle margin-right-2"></i></span>
                    @else
                        <span class="icon-text no"><i class="icon-feather-x-circle margin-right-2"></i></span>
                    @endif
                    {{ ___('Hide Branding') }}
                </li>
                <li>
                    @if (!@$plan->settings->advertisements)
                        <span class="icon-text yes"><i class="icon-feather-check-circle margin-right-2"></i></span>
                    @else
                        <span class="icon-text no"><i class="icon-feather-x-circle margin-right-2"></i></span>
                    @endif
                    {{ ___('No Advertisements') }}
                </li>

                @if (@$plan->settings->custom_features)
                    @foreach ($plan->settings->custom_features as $key => $value)
                        <li>
                            @php $planoption = plan_option($key) @endphp

                            @if ($value)
                                <span class="icon-text yes"><i
                                        class="icon-feather-check-circle margin-right-2"></i></span>
                            @else
                                <span class="icon-text no"><i class="icon-feather-x-circle margin-right-2"></i></span>
                            @endif

                            {{ !empty($planoption->translations->{get_lang()}->title)
                                ? $planoption->translations->{get_lang()}->title
                                : $planoption->title }}
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        @if(auth()->check() && request()->user()->group_id == $plan->id)
            <button class="button full-width margin-top-20 ripple-effect disabled"
                    disabled>{{___('Current Plan')}}</button>
        @else
            <button type="submit" class="button btn-primary text-align-center margin-top-20 ripple-effect" name="plan"
                    value="{{ $plan->id }}">{{___('Choose Plan')}}</button>
        @endif
    </div>
@endif
