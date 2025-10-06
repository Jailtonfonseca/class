<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Edit City') }} - <span style="white-space: nowrap;">{{$city->country->name}}</span></h2>
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
        <form action="{{ route('admin.cities.update', $city->id) }}" method="post" id="sidePanel_form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ ___('Name') }} : <span class="red">*</span></label>
                <input type="text" name="name" value="{{ $city->name}}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Latitude') }} : <span class="red">*</span></label>
                <input type="text" name="latitude" value="{{ $city->latitude}}" class="form-control" required>
                <p>In decimal degrees (wgs84)</p>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Longitude') }} : <span class="red">*</span></label>
                <input type="text" name="longitude" value="{{ $city->longitude}}" class="form-control" required>
                <p>In decimal degrees (wgs84)</p>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Population') }} : <span class="red">*</span></label>
                <input type="text" name="population" value="{{ $city->population}}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Time Zone ID') }} : <span class="red">*</span></label>
                <input type="text" name="time_zone" value="{{ $city->time_zone}}" class="form-control" required>
                <p style="font-size: 14px">Please check the TimeZoneId code format here: <a href="http://download.geonames.org/export/dump/timeZones.txt">http://download.geonames.org/export/dump/timeZones.txt</a></p>
            </div>
            <div class="mb-3">
                {{quick_switch(___('Active'), 'active', $city->active == '1')}}
            </div>
        </form>
    </div>
</div>
