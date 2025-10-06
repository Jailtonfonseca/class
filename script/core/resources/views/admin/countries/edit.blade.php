<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Edit Country') }} - <span style="white-space: nowrap;">{{ $countryData->name }}</h2>
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
        <form action="{{ route('admin.countries.update', $countryData->code) }}" method="post" id="sidePanel_form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ ___('Country Code') }} : <span class="red">*</span></label>
                <input type="text" name="code" class="form-control" value="{{ $countryData->code }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Name') }} : <span class="red">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ $countryData->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Phone Code. (Optional)') }} : <span class="red">*</span></label>
                <input type="text" name="phone" class="form-control" value="{{ $countryData->phone }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Currency Code') }} : <span class="red">*</span></label>
                <select name="currency" class="form-control">
                    @foreach ($currencies as $currency)
                    @if ($currency->code == $countryData->code)
                    <option selected value="{{$countryData->code}}">{{$countryData->code}}</option>
                    @endif
                    <option value="{{$currency->code}}">{{ $currency->code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Language') }} : <span class="red">*</span></label>
                <input type="text" name="language" value="{{$countryData->languages}}" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Latitude') }} : <span class="red">*</span></label>
                <input type="text" name="latitude" class="form-control" value="{{ $countryData->latitude }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Longitude') }} : <span class="red">*</span></label>
                <input type="text" name="longitude" class="form-control" value="{{ $countryData->longitude }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Map Zoom') }} : <span class="red">*</span></label>
                <input type="text" name="map_zoom" class="form-control" value="{{ $countryData->map_zoom }}">
            </div>
        </form>
    </div>
</div>
