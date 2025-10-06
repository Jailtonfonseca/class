<div class="quickad-flexbox">
    <div class="quickad-flex-cell quickad-vertical-middle">
        <i title="Reorder" class="quickad-js-handle quickad-icon quickad-icon-draghandle quickad-margin-right-sm quickad-cursor-move"></i>
    </div>
    <div class="quickad-flex-cell quickad-vertical-middle" style="width: 100%">
        <div class="translate-fields translate-fields-default">
            <input class="form-control option_default" type="text"
                   name="options[{key}][name]"
                   placeholder="{{ ___('Option Name') }}">
        </div>
        @foreach ($admin_languages as $language)
            <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                <input type="text" class="form-control translate-fields-input"
                       name="options[{key}][translations][{{ $language->code }}][name]"
                       placeholder="{{ $language->name }} {{ ___('Option Name') }}">
            </div>
        @endforeach
    </div>
    <div class="quickad-flex-cell quickad-vertical-middle">
        <a class="quickad-option-delete icon-feather-x text-danger quickad-margin-left-sm" href="#" title="{{ ___('Remove Option') }}"></a>
    </div>
</div>
