<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h3>{{ ___('Add City') }} - <span style="white-space: nowrap;">{{$country->name}}</span></h3>
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
        <form action="{{route('admin.cities.store')}}" method="post" id="sidePanel_form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="country_code" value="{{$country->code}}">
            <div class="mb-3">
            <label class="form-label">{{ ___('Region (Admin1 Code)') }} : <span class="red">*</span></label>
            <select name="subadmin1" id="region-select" class="form-control">
                <option value="">{{ ___('Select Region') }}</option>
                @foreach($regions as $region)
                <option value="{{ $region->code }}">{{ $region->name }}</option>
                @endforeach
            </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('District (Admin2 Code)') }} : <span class="red">*</span></label>
                <select name="subadmin2" id="district-select" class="form-control">
                </select>
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
                <label class="form-label">{{ ___('Latitude') }} : <span class="red">*</span></label>
                <input type="text" name="latitude" class="form-control" required>
                <p>In decimal degrees (wgs84)</p>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Longitude') }} : <span class="red">*</span></label>
                <input type="text" name="longitude" class="form-control" required>
                <p>In decimal degrees (wgs84)</p>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Population') }} : <span class="red">*</span></label>
                <input type="text" name="population" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Time Zone ID') }} : <span class="red">*</span></label>
                <input type="text" name="time_zone" class="form-control" required>
                <p >Please check the TimeZoneId code format here: <a href="http://download.geonames.org/export/dump/timeZones.txt">http://download.geonames.org/export/dump/timeZones.txt</a></p>
            </div>
            <div class="mb-3">
                {{quick_switch(___('Active'), 'active', 'active')}}
            </div>
        </form>
    </div>
</div>
{{--  dependent dropdown js --}}
<script type="text/javascript">
$(document).ready(function () {
        $('#region-select').on('change', function () {
            var regionCode = $(this).val();
            if (regionCode) {
                $.ajax({
                    url: '{{ url("admin/regions") }}/' + regionCode + '/districts',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#district-select').empty().append('<option value="">{{ ___("Select District") }}</option>');
                        $.each(data, function (key, value) {
                            $('#district-select').append('<option value="' + value.code + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#district-select').empty().append('<option value="">{{ ___("Select District") }}</option>');
            }
        });
    });
</script>
