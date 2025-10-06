<label class="form-label d-flex align-items-center">
    {{ $title }}
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
<div class="input-group mb-3">
    <div class="translate-fields translate-fields-default">
        <input class="quickad-label form-control" type="text" name="name" placeholder="{{ ___('Field Name') }}"
               value="{{ $customfield->title }}">
    </div>
    @foreach ($admin_languages as $language)
        <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
            <input type="text" class="form-control"
                   name="translations[{{ $language->code }}][name]"
                   placeholder="{{ $language->name }} {{ ___('Field Name') }}"
                   value="{{ !empty($customfield->translation_lang->{$language->code}->name) ? $customfield->translation_lang->{$language->code}->name : $customfield->title }}">
        </div>
    @endforeach
    <label class="input-group-addon">
        <div class="checkbox">
            <input type="checkbox" name="required" id="required" value="1" class="quickad-required" @if($customfield->required) checked="checked" @endif>
            <label for="required" class="w-100">
                <span class="checkbox-icon"></span> {{ ___("Required field") }}
            </label>
        </div>
    </label>
</div>
