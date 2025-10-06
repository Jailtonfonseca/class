<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Add Timezone') }}</h2>
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
        <form action="{{ route('admin.timezones.store') }}" method="post" id="sidePanel_form" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ ___('Country') }} : <span class="red">*</span></label>
                <select name="country" class="form-control">
                    <option value="">{{ ___('Select Country') }}</option>
                    @foreach ($countries as $country)                      
                    <option value="{{$country->code}}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Time Zone') }} : <span class="red">*</span></label>
                <input type="text" name="timezone" class="form-control" required>
                <p class="text-muted " style="font-size: 13px">Please check the TimeZoneId code format here: <a href="http://download.geonames.org/export/dump/timeZones.txt">http://download.geonames.org/export/dump/timeZones.txt</a></p>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('GMT') }} : <span class="red">*</span></label>
                <input type="text" name="gmt" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('DST') }} : <span class="red">*</span></label>
                <input type="text" name="dst" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('RAW') }} : <span class="red">*</span></label>
                <input type="text" name="raw" class="form-control" required>
            </div>
        </form>
    </div>
</div>
