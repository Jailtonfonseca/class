(function ($) {
    $(document).ready(function () {
        //Country popup keyword search
        $(document).on('keyup', '#country-modal-search', function () {
            var searchTerm = $(this).val().toLowerCase();
            $('#countries').find('li').each(function () {
                if ($(this).filter(function() {
                    return $(this).attr('data-name').toLowerCase().indexOf(searchTerm) > -1;
                }).length > 0 || searchTerm.length < 1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        //Country popup keyword search
        /* === Search city === */
        $('#country-popup').on('click', '#getCities ul li .statedata', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $('#getCities #results').hide();
            $('#getCities .loader').show();
            var $item = $(this).closest('.statedata');
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: {
                    action: 'ModelGetCityByStateID',
                    id: $item.data('id')
                },
                success: function (response) {
                    $("#getCities #results").html(response.data);
                    $('#getCities .loader').hide();
                    $('#getCities #results').show();
                }
            });
        });

        $('#country-popup').on('click', '#getCities ul li #changeState', function (e) {
            // Keep ads item click from being executed.
            e.stopPropagation();
            // Prevent navigating to '#'.
            e.preventDefault();
            // Ask user if he is sure.
            $('#getCities #results').hide();
            $('#getCities .loader').show();
            var $item = $(this).closest('.quick-states');

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: {
                    action: 'ModelGetStateByCountryID',
                    id: $item.data('country-id')
                },
                success: function (response) {
                    $("#getCities #results").html(response.data);
                    $('#getCities .loader').hide();
                    $('#getCities #results').show();
                }
            });
        });

        $('#country-popup').on('click', 'ul li .selectme', function (e) {
            e.stopPropagation();
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var type = $(this).data('type');
            $('#inputStateCity').val(name);
            $('#searchStateCity').val(name);
            $('#headerStateCity').html(name + ' <i class="fa fa-pencil"></i>');
            $('#searchPlaceType').val(type);
            $('#searchPlaceId').val(id);
            if ($('#countryModal').length) {
                $.magnificPopup.close();
            }

            localStorage.Quick_placeText = name;
            localStorage.Quick_PlaceId = id;
            localStorage.Quick_PlaceType = type;
            $("#searchDisplay").html('').hide();
        });

        $(document).on('click', '.locationStorage', function (e) {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var type = $(this).data('type');
            localStorage.Quick_placeText = name;
            localStorage.Quick_PlaceId = id;
            localStorage.Quick_PlaceType = type;
            $("#searchDisplay").html('').hide();
        });

        $('.category-dropdown').on('click', '#category-change a', function (ev) {
            if ("#" === $(this).attr('href')) {
                ev.preventDefault();
                var parent = $(this).parents('.category-dropdown');
                parent.find('.change-text').html($(this).html());
                var id = $(this).data('ajax-id');
                var type = $(this).data('cat-type');

                if (type == "all") {
                    $('#input-subcat').val('');
                    $('#input-maincat').val('');
                }
                else if (type == "maincat") {
                    $('#input-subcat').val('');
                }
                else {
                    $('#input-maincat').val('');
                }
                $('#input-' + type).val(id);
            }
        }).on('click', '#category-change .dropdown-arrow', function (e) {
            e.preventDefault();
            $(this).parent().toggleClass('open');
            return false;
        });

        $('#searchStateCity').on('click', function () {
            $('#change-city').trigger('click');
        });

        if (localStorage.Quick_placeText != "") {
            var placeText = localStorage.Quick_placeText;
            var PlaceId = localStorage.Quick_PlaceId;
            var PlaceType = localStorage.Quick_PlaceType;

            if (placeText != null) {
                $('#inputStateCity').val(placeText);
                $('#searchStateCity').val(placeText);
                $('#headerStateCity').html(placeText + ' <i class="fa fa-pencil"></i>');
                $('#searchPlaceId').val(PlaceId);
                $('#searchPlaceType').val(PlaceType);
            }
        }

        var searchCityAjax = null;
        $("#inputStateCity").keyup(function () {
            if (searchCityAjax) {
                searchCityAjax.abort();
            }
            var searchbox = $(this).val();

            if (searchbox == '') {
                $('#searchDisplay').hide();
            }
            else {
                $('#searchDisplay').show();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: {
                        'action': 'searchStateCountry',
                        'dataString': searchbox
                    },
                    success: function (response) {
                        $("#searchDisplay").html(response.data).show();
                    }
                });
            }
            return false;
        });

        var inputField = $('.qucikad-ajaxsearch-input');
        var inputSubcatField = $('#input-subcat');
        var inputCatField = $('#input-maincat');
        var inputKeywordsField = $('#input-keywords');
        var myDropDown = $("#qucikad-ajaxsearch-dropdown");
        var myDropDown1 = $("#qucikad-ajaxsearch-dropdown ul li");
        var myDropOption = $('#qucikad-ajaxsearch-dropdown > option');
        var html = $('html');
        var select = $('.qucikad-ajaxsearch-input, #qucikad-ajaxsearch-dropdown > option');
        var lps_tag = $('.qucikad-as-tag');
        var lps_cat = $('.qucikad-as-cat');


        $("#def-cats").append($('#qucikad-ajaxsearch-dropdown ul').html());

        var length = myDropOption.length;
        inputField.on('click', function (event) {
            //event.preventDefault();
            myDropDown.attr('size', length);
            myDropDown.css('display', 'block');
        });

        //myDropDown1.on('click', function(event) {
        $(document).on('click', '#qucikad-ajaxsearch-dropdown ul li', function (event) {
            myDropDown.attr('size', 0);
            var dropValue = $.trim($(this).text());
            var tagVal = $(this).data('tagid');
            var catVal = $(this).data('catid');
            var moreVal = $(this).data('moreval');

            inputField.val(dropValue);
            inputSubcatField.val(tagVal);
            inputCatField.val(catVal);
            inputKeywordsField.val("");
            if (tagVal == null && catVal == null && moreVal != null) {
                inputField.val(moreVal);
                inputKeywordsField.val(moreVal);
            }
            $("form i.qucikad-ajaxsearch-close").css("display", "block");
            myDropDown.css('display', 'none');
        });

        $('form i.qucikad-ajaxsearch-close').on('click', function () {
            $("form i.qucikad-ajaxsearch-close").css("display", "none");
            $('form .qucikad-ajaxsearch-input').val('');
            $("img.loadinerSearch").css("display", "block");
            var qString = '';

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: {
                    'action': 'ajaxHomeSearch',
                    'tagID': qString
                },
                success: function (data) {
                    if (data) {
                        $("#qucikad-ajaxsearch-dropdown ul").empty();
                        var resArray = [];
                        if (data.suggestions.cats) {
                            $.each(data.suggestions.cats, function (i, v) {
                                resArray.push(v);
                            });

                        }
                        $('img.loadinerSearch').css('display', 'none');
                        $("#qucikad-ajaxsearch-dropdown ul").append(resArray);
                        myDropDown.css('display', 'block');
                    }
                }
            });
            $('img.loadinerSearch').css('display', 'none');
        });

        html.on('click', function (event) {
            //event.preventDefault();
            myDropDown.attr('size', 0);
            myDropDown.css('display', 'none');
            //$("#searchDisplay").attr('size', 0);
            $("#searchDisplay").css('display', 'none');
        });

        select.on('click', function (event) {
            event.stopPropagation();
        });

        var resArray = [];
        var newResArray = [];
        var bufferedResArray = [];
        var prevQString = '?';

        function trimAttributes(node) {
            $.each(node.attributes, function () {
                var attrName = this.name;
                var attrValue = this.value;
                // remove attribute name start with "on", possible unsafe,
                // for example: onload, onerror...
                //
                // remvoe attribute value start with "javascript:" pseudo protocol, possible unsafe,
                // for example href="javascript:alert(1)"
                if (attrName.indexOf('on') == 0 || attrValue.indexOf('javascript:') == 0) {
                    $(node).removeAttr(attrName);
                }
            });
        }

        function sanitize(html) {
            var output = $($.parseHTML('<div>' + html + '</div>', null, false));
            output.find('*').each(function () {
                trimAttributes(this);
            });
            return output.html();
        }

        inputField.on('input', function () {
            var $this = $(this);
            var qString = sanitize(this.value);
            lpsearchmode = $('body').data('lpsearchmode');
            lpsearchmode = "titlematch";
            noresultMSG = $(this).data('noresult');
            $("#qucikad-ajaxsearch-dropdown ul").empty();
            $("#qucikad-ajaxsearch-dropdown ul li").remove();
            prevQuery = $this.data('prev-value');
            $this.data("prev-value", qString.length);
            inputKeywordsField.val(qString);

            if (qString.length == 0) {

                defCats = $('#def-cats').html();
                myDropDown.css('display', 'none');
                $("#qucikad-ajaxsearch-dropdown ul").html(defCats);
                myDropDown.css('display', 'block');
                $this.data("prev-value", qString.length);
                inputKeywordsField.val("");
                $("form i.qucikad-ajaxsearch-close").css("display", "none");
            }
            else if ((qString.length == 1 && prevQString != qString) || (qString.length == 1 && prevQuery < qString.length)) {

                myDropDown.css('display', 'none');
                $("#qucikad-ajaxsearch-dropdown ul").empty();
                resArray = [];
                //$('#selector').val().length
                $("form i.qucikad-ajaxsearch-close").css("display", "block");
                $("img.loadinerSearch").css("display", "block");
                //$(this).addClass('loaderimg');
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxurl,
                    data: {
                        'action': 'ajaxHomeSearch',
                        'tagID': qString
                    },
                    success: function (data) {
                        if (data) {

                            if (data.suggestions.tag || data.suggestions.tagsncats || data.suggestions.cats || data.suggestions.titles) {

                                if (data.suggestions.tag) {
                                    $.each(data.suggestions.tag, function (i, v) {
                                        resArray.push(v);
                                    });
                                }

                                if (data.suggestions.tagsncats) {
                                    $.each(data.suggestions.tagsncats, function (i, v) {
                                        resArray.push(v);
                                    });

                                }


                                if (data.suggestions.cats) {
                                    $.each(data.suggestions.cats, function (i, v) {

                                        resArray.push(v);

                                    });

                                    if (data.suggestions.tag == null && data.suggestions.tagsncats == null && data.suggestions.titles == null) {
                                        resArray = resArray;
                                    }
                                    else {
                                    }
                                }

                                if (data.suggestions.titles) {
                                    $.each(data.suggestions.titles, function (i, v) {

                                        resArray.push(v);

                                    });

                                }

                            }
                            else {
                                if (data.suggestions.more) {
                                    $.each(data.suggestions.more, function (i, v) {
                                        resArray.push(v);
                                    });

                                }
                            }

                            prevQString = data.tagID;

                            $('img.loadinerSearch').css('display', 'none');
                            if ($('form #select').val() == '') {
                                $("form i.qucikad-ajaxsearch-close").css("display", "none");
                            }
                            else {
                                $("form i.qucikad-ajaxsearch-close").css("display", "block");
                            }

                            bufferedResArray = resArray;
                            filteredRes = [];
                            qStringNow = $('.qucikad-ajaxsearch-input').val();
                            $.each(resArray, function (key, value) {

                                if ($(value).find('a').length == "1") {
                                    rText = $(value).find('a').text();
                                }
                                else {
                                    rText = $(value).text();
                                }

                                if (lpsearchmode == "keyword") {

                                    qStringNow = qStringNow.toUpperCase();
                                    rText = rText.toUpperCase();
                                    var regxString = new RegExp(qStringNow, 'g');
                                    var lpregxRest = rText.match(regxString);
                                    if (lpregxRest) {
                                        filteredRes.push(value);
                                    }

                                } else {
                                    if (rText.substr(0, qStringNow.length).toUpperCase() == qStringNow.toUpperCase()) {
                                        filteredRes.push(value);
                                    }
                                }
                            });

                            if (filteredRes.length > 0) {
                                myDropDown.css('display', 'none');
                                $("#qucikad-ajaxsearch-dropdown ul").empty();

                                $("#qucikad-ajaxsearch-dropdown ul").append(filteredRes);
                                myDropDown.css('display', 'block');
                                $this.data("prev-value", qString.length);

                            }

                            else if (filteredRes.length < 1 && qStringNow.length < 2) {
                                myDropDown.css('display', 'none');
                                $("#qucikad-ajaxsearch-dropdown ul").empty();
                                $('#qucikad-ajaxsearch-dropdown ul li').remove();
                                $mResults = '<strong>' + noresultMSG + ' </strong>';
                                $mResults = $mResults + qString;
                                var defRes = '<li class="qucikad-ajaxsearch-li-more-results" data-moreval="' + qString + '">' + $mResults + '</li>';
                                newResArray.push(defRes);
                                $("#qucikad-ajaxsearch-dropdown ul").append(newResArray);
                                myDropDown.css('display', 'block');
                                $this.data("prev-value", qString.length);
                            }
                        }
                    }

                });
            }
            /* get results from buffered data */
            else {
                newResArray = [];
                myDropDown.css('display', 'none');
                $("#qucikad-ajaxsearch-dropdown ul").empty();
                $.each(bufferedResArray, function (key, value) {
                    var stringToCheck = $(value).find('span').first().text();

                    if (lpsearchmode == "keyword") {

                        qString = qString.toUpperCase();
                        stringToCheck = stringToCheck.toUpperCase();

                        var regxString = new RegExp(qString, 'g');
                        var lpregxRest = stringToCheck.match(regxString);
                        if (lpregxRest) {
                            newResArray.push(value);
                        }

                    } else {

                        if (stringToCheck.substr(0, qString.length).toUpperCase() == qString.toUpperCase()) {
                            newResArray.push(value);
                        }
                    }
                });
                if (newResArray.length == 0) {
                    $("#qucikad-ajaxsearch-dropdown ul").empty();
                    $('#qucikad-ajaxsearch-dropdown ul li').remove();
                    $mResults = '<strong>' + noresultMSG + ' </strong>';
                    $mResults = $mResults + qString;
                    var defRes = '<li class="qucikad-ajaxsearch-li-more-results" data-moreval="' + qString + '">' + $mResults + '</li>';
                    newResArray.push(defRes);
                }

                $("#qucikad-ajaxsearch-dropdown ul").append(newResArray);
                myDropDown.css('display', 'block');
                $("form i.qucikad-ajaxsearch-close").css("display", "block");
            }
        });
    });


    /* 1 */
    /* Live Location Detect
    /* ========================================================================== */
    $(document).ready(function($) {
        var loc = $('.loc-tracking').data('option');
        var apiType = $('#page').data('ipapi');
        var currentlocationswitch = '1';
        currentlocationswitch = $('#page').data('showlocationicon');

        if (currentlocationswitch == "0") {
            loc = 'locationifoff';
            $('.loc-tracking > i').fadeOut('fast');
        }

        if (typeof localStorage.Quick_placeText !== 'undefined' && localStorage.Quick_placeText != ""){
            $('.live-location-search .loc-tracking > i').fadeOut('slow');
            return;
        }

        if (loc == 'yes') {
            if ($('.intro-search-field').is('.live-location-search')) {
                if (apiType === "geo_ip_db") {
                    $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?')
                        .done(function (location) {

                            getCityidByCityName(location.country_code, location.state, location.city);
                            $('input[name=location]').val(location.city);
                            $('.live-location-search .loc-tracking > i').fadeOut('slow');
                        });
                }
                else if (apiType === "ip_api") {
                    $.get("https://ipapi.co/json", function (location) {

                        getCityidByCityName(location.country, location.region, location.city);
                        $('input[name=location]').val(location.city);

                        $('.live-location-search .loc-tracking > i').fadeOut('slow');
                    }, "json");
                }
                else {
                    GetCurrentGpsLoc(function (GpsLocationCityData) {
                        myCurrentGpsLocation = GpsLocationCityData;
                        getCityidByCityName(myCurrentGpsLocation.country, myCurrentGpsLocation.region, myCurrentGpsLocation.city);
                        $('input[name=location]').val(myCurrentGpsLocation.city);

                        $('.live-location-search .loc-tracking > i').fadeOut('slow');
                    });
                }

            }
        }
        else if (loc == 'no') {
            $('.live-location-search .loc-tracking > i').on('click', function (event) {
                event.preventDefault();
                $(this).addClass('fa-circle-o-notch fa-spin');
                $(this).removeClass('fa-crosshairs');
                if ($('.intro-search-field').is('.live-location-search')) {
                    if (apiType === "geo_ip_db") {
                        $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?')
                            .done(function (location) {

                                if (location.city == null) {
                                }
                                else {
                                    getCityidByCityName(location.country_code, location.state, location.city);
                                    $('input[name=latitude]').val(location.latitude);
                                    $('input[name=longitude]').val(location.longitude);
                                    $('input[name=location]').val(location.city);
                                }
                                $('.live-location-search .loc-tracking > i').fadeOut('slow');
                            });
                    }
                    else if (apiType === "ip_api") {
                        $.get("https://ipapi.co/json", function (location) {
                            if (location.city == null) {
                            }
                            else {
                                getCityidByCityName(location.country, location.region, location.city);

                                $('input[name=latitude]').val(location.latitude);
                                $('input[name=longitude]').val(location.longitude);
                                $('input[name=location]').val(location.city);
                            }
                            $('.live-location-search .loc-tracking > i').fadeOut('slow');

                        }, "json");
                    }
                    else {

                        GetCurrentGpsLoc(function (GpsLocationCityData) {
                            myCurrentGpsLocation = GpsLocationCityData;
                            getCityidByCityName(myCurrentGpsLocation.country, myCurrentGpsLocation.region, myCurrentGpsLocation.city);
                            $('input[name=location]').val(myCurrentGpsLocation.city);
                            $('.live-location-search .loc-tracking > i').fadeOut('slow');
                        });

                    }
                }
            });
        }else{
            $('.live-location-search .loc-tracking > i').fadeOut('slow');
        }
    });
})(this.jQuery);

//GPS LIVE LOCATION
var geocoderr;
function GetCurrentGpsLoc(lpcalback){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position){
            var clat = position.coords.latitude;
            var clong = position.coords.longitude;
            jpCodeLatLng(clat,clong, function(citynamevalue){

                lpcalback(citynamevalue);

            });
        });

    } else {
        alert("Geolocation is not supported by this browser.");
    }

}

function lpgeocodeinitialize() {
    geocoderr = new google.maps.Geocoder();
}

function jpCodeLatLng(lat, lng, lpcitycallback) {
    latlng = new google.maps.LatLng(lat, lng),
        geocoderrr = new google.maps.Geocoder();
    geocoderrr.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                for (var i = 0; i < results.length; i++) {
                    if (results[i].types[0] === "locality") {
                        var city = results[i].address_components[0].short_name;
                        var region = results[i].address_components[2].long_name;
                        var country = results[i].address_components[3].short_name;

                        var $citydata = {};
                        $citydata['city'] = city;
                        $citydata['region'] = region;
                        $citydata['country'] = country;
                        lpcitycallback($citydata);
                    }
                }
            }
            else {console.log("No reverse geocode results.")}
        }
        else {console.log("Geocoder failed: " + status)}
    });
}

function getCityidByCityName(country,state,city) {
    var data = {action: "getCityidByCityName", city: city, state: state, country: country};
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        url: ajaxurl,
        data: data,
        success: function (response) {
            $('#searchPlaceType').val("city");
            $('#searchPlaceId').val(response.id);

            localStorage.Quick_placeText = city;
            localStorage.Quick_PlaceId = response.id;
            localStorage.Quick_PlaceType = "city";
        }
    });
}
