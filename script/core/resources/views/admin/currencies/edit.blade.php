<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Edit Currency') }}</h2>
            </div>
            <div class="slidePanel-actions">
                <button id="post_sidePanel_data" class="btn btn-icon btn-primary" title="{{ ___('Save') }}">
                    <i class="icon-feather-check"></i>
                </button>
                <button class="btn btn-default btn-icon slidePanel-close" title="{{ ___('Close') }}">
                    <i class="icon-feather-x"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="slidePanel-inner">
        <form action="{{ route('admin.currencies.update', $currencies->id) }}" method="post" id="sidePanel_form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="currencyId" value="{{$currencies->id}}">
            <div class="mb-3">
                <label class="form-label">{{ ___('Code') }} : <span class="red">*</span></label>
                <input type="text" name="code" class="form-control" value="{{ $currencies->code }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Name') }} : <span class="red">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ $currencies->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Html Entity') }} : <span class="red">*</span></label>
                <input type="text" name="html_entity" class="form-control" value="{{ $currencies->html_entity }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Font Arial') }} : <span class="red">*</span></label>
                <input type="text" name="font_arial" class="form-control" value="{{ $currencies->font_arial  }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Font Code2000') }} : <span class="red">*</span></label>
                <input type="text" name="font_code2000" class="form-control" value="{{ $currencies->font_code2000 }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Unicode Decimal') }} : <span class="red">*</span></label>
                <input type="text" name="unicode_decimal" class="form-control" value="{{ $currencies->unicode_decimal }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Unicode Hex') }} : <span class="red">*</span></label>
                <input type="text" name="unicode_hex" class="form-control" value="{{ $currencies->unicode_hex }}" required>
            </div>
            <div class="mb-3">
                {{quick_switch(___('Symbol in left'), 'in_left', $currencies->in_left == '1')}}
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Decimal Places') }} : <span class="red">*</span></label>
                <input type="text" name="decimal_places" class="form-control" value="{{ $currencies->decimal_places }}" required>
                <p class="text-muted">Number after decimal. Ex: 2 => 150.00 [or] 3 => 150.000</p>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Decimal Separator') }} : <span class="red">*</span></label>
                <input type="text" name="decimal_separator" class="form-control" value="{{ $currencies->decimal_separator }}" required>
                <p class="text-muted">Ex: "." => 100.00 [or] "," => 100,00</p>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Thousand Separator') }} : <span class="red">*</span></label>
                <input type="text" name="thousand_separator" class="form-control" value="{{ $currencies->thousand_separator }}" required>
                <p class="text-muted">Ex: "," => 100,000.00 [or] whitespace => 100 000.000</p>
            </div>
        </form>
    </div>
</div>
