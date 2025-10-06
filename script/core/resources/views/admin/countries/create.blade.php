<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Add Country') }}</h2>
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
        <form action="{{ route('admin.countries.store') }}" method="post" id="sidePanel_form" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ ___('Country Code') }} : <span class="red">*</span></label>
                <input type="text" name="code" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Local Name') }} : <span class="red">*</span></label>
                <input type="text" name="local_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Name') }} : <span class="red">*</span></label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Currency Code') }} : <span class="red">*</span></label>
                <select name="currency" class="form-control">
                    <option value="">{{ ___('-') }}</option>
                    @foreach ($currencies as $currency)
                    <option value="{{$currency->code}}">{{ $currency->code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Phone Code. (Optional)') }} : <span class="red">*</span></label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Language') }} : <span class="red">*</span></label>
                <input type="text" name="language" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Latitude') }} : <span class="red">*</span></label>
                <input type="text" name="latitude" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Longitude') }} : <span class="red">*</span></label>
                <input type="text" name="longitude" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Map Zoom') }} : <span class="red">*</span></label>
                <input type="text" name="map_zoom" class="form-control">
            </div>
        </form>
    </div>
</div>
