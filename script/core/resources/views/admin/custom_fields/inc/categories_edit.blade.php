<div class="mb-3">
    <div class="btn-group quickad-services-holder quickad-margin-top-screenxs-sm w-100">
        <button class="btn btn-default btn-block dropdown-toggle quickad-flexbox" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            <div class="quickad-flex-cell">
                <i class="icon-feather-tag quickad-margin-right-md"></i>
            </div>
            <div class="quickad-flex-cell text-left" style="width: 100%">
                <span class="quickad-js-count">No category selected</span>
            </div>
            <div class="quickad-flex-cell"><div class="quickad-margin-left-md"><span class="caret"></span></div></div>
        </button>
        <ul class="dropdown-menu quickad-entity-selector w-100" style="overflow-y: scroll;height: 300px">
            <li>
                <div class="checkbox">
                    <input type="checkbox" name="all_category" value="any" class="quick-check quickad-check-all-entities">
                    <label class="w-100"><span class="checkbox-icon"></span> {{ ___("All Category") }}</label>
                </div>
            </li>
            @foreach (categories() as $cat)
                <li class="main-category">
                    <div class="checkbox">
                        <input name="main_category[]" type="checkbox" value="{{ $cat->id }}" data-title="{{ $cat->name }}" id="checkmain_{{ $cat->id }}" class="quick-check quickad-js-check-entity">
                        <label for="checkmain_{{ $cat->id }}" class="w-100">
                            <span class="checkbox-icon"></span>
                            <i class="{{ $cat->icon }}"></i>
                            {{ $cat->name }}
                        </label>
                    </div>
                    <ul style="margin-left: 28px;">
                        @foreach (subcategories($cat->id) as $sub)
                            <li class="subcategory">
                                <div class="checkbox">
                                    <input type="checkbox" name="sub_category[]"
                                           value="{{ $sub->id }}"
                                           data-title="{{ $sub->name }}"
                                           id="checksub_{{ $sub->id }}"
                                           class="quick-check quickad-js-check-sub-entity">
                                    <label for="checksub_{{ $sub->id }}"
                                           class="w-100">
                                        <span class="checkbox-icon"></span>
                                        <i class="{{ $sub->icon }}"></i>
                                        {{ $sub->name }}
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</div>
