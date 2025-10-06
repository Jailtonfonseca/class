(function () {
    'use strict';

    const theme = {

        init: () => {
            theme.interactiveMap();
        },

        /**
         * Interactive map
         * @requires https://github.com/Leaflet/Leaflet
         */
        interactiveMap: () => {
            var mapList = document.querySelectorAll('.interactive-map');
            if (mapList.length === 0) return;

            var _loop5 = function _loop5(i) {
                var mapOptions = mapList[i].dataset.mapOptions,
                    mapOptionsExternal = mapList[i].dataset.mapOptionsJson,
                    map = void 0; // Map options: Inline JSON data

                if (mapOptions && mapOptions !== '') {
                    var mapOptionsObj = JSON.parse(mapOptions),
                        mapLayer = mapOptionsObj.mapLayer || 'https://api.maptiler.com/maps/pastel/{z}/{x}/{y}.png?key=5vRQzd34MMsINEyeKPIs',
                        mapCoordinates = mapOptionsObj.coordinates ? mapOptionsObj.coordinates : [0, 0],
                        mapZoom = mapOptionsObj.zoom || 1,
                        scrollWheelZoom = mapOptionsObj.scrollWheelZoom === false ? false : true,
                        markers = mapOptionsObj.markers; // Map setup

                    map = L.map(mapList[i], {
                        scrollWheelZoom: scrollWheelZoom
                    }).setView(mapCoordinates, mapZoom); // Tile layer


                    L.tileLayer(mapLayer, {
                        tileSize: 512,
                        zoomOffset: -1,
                        minZoom: 1,
                        attribution: "<a href=\"https://www.maptiler.com/copyright/\" target=\"_blank\">&copy; MapTiler</a> <a href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\">&copy; OpenStreetMap contributors</a>",
                        crossOrigin: true
                    }).addTo(map); // Markers

                    L.markerClusterGroup({
                        spiderfyOnMaxZoom: true,
                        showCoverageOnHover: false,
                    }).addTo(map); // Markers

                    if (markers) {
                        for (n = 0; n < markers.length; n++) {
                            var iconUrl = markers[n].iconUrl,
                                iconClass = markers[n].className,
                                markerIcon = L.icon({
                                    iconUrl: _iconUrl || siteurl + '/assets/global/img/marker-icon.png',
                                    iconSize: [25, 39],
                                    iconAnchor: [12, 39],
                                    shadowUrl: siteurl + '/assets/global/img/marker-shadow.png',
                                    shadowSize: [41, 41],
                                    shadowAnchor: [13, 41],
                                    popupAnchor: [1, -28],
                                    className: iconClass
                                }),
                                popup = markers[n].popup;

                            var hireoIcon = L.divIcon({
                                    iconAnchor: [0, 0], // point of the icon which will correspond to marker's location
                                    popupAnchor: [0, 0],
                                    className: 'hireo-marker-icon',
                                    html:  '<div class="marker-container">'+
                                        '<div class="marker-card">'+
                                        '<div class="marker-arrow"></div>'+
                                        '</div>'+
                                        '</div>'
                                }
                            );
                            var marker = L.marker(markers[n].coordinates, {
                                icon: hireoIcon
                            }).addTo(map);

                            if (popup) {
                                marker.bindPopup(popup);
                            }
                        }
                    } // Map options: External JSON file

                }
                else if (mapOptionsExternal && mapOptionsExternal !== '') {
                    var form = $('#mapSearchForm');
                    var ajaxData = form.serialize();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: ajaxurl,
                        type: "POST",
                        dataType: "json",
                        data: ajaxData,
                        cache: false,
                        success: function(data){
                            var mapLayer = 'https://api.maptiler.com/maps/pastel/{z}/{x}/{y}.png?key=5vRQzd34MMsINEyeKPIs',
                                mapCoordinates = [_latitude,_longitude],
                                mapZoom = mapDefaultZoom,
                                scrollWheelZoom = false,
                                markers = data; // Map setup

                            map = L.map(mapList[i], {
                                scrollWheelZoom: scrollWheelZoom
                            }).setView(mapCoordinates, mapZoom); // Tile layer

                            L.tileLayer(mapLayer, {
                                tileSize: 512,
                                zoomOffset: -1,
                                minZoom: 1,
                                closePopupOnClick: true,
                                attribution: "<a href=\"https://www.maptiler.com/copyright/\" target=\"_blank\">&copy; MapTiler</a> <a href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\">&copy; OpenStreetMap contributors</a>",
                                crossOrigin: true
                            }).addTo(map); // Markers

                            L.markerClusterGroup({
                                spiderfyOnMaxZoom: true,
                                showCoverageOnHover: false,
                            }).addTo(map); // Markers

                            if (markers) {
                                for (var n = 0; n < markers.length; n++) {
                                    var _iconUrl = markers[n].iconUrl,
                                        _iconClass = markers[n].className,
                                        _markerIcon = L.icon({
                                            iconUrl: _iconUrl || siteurl + '/assets/global/img/marker-icon.png',
                                            iconSize: [25, 39],
                                            iconAnchor: [12, 39],
                                            shadowUrl: siteurl + '/assets/global/img/marker-shadow.png',
                                            shadowSize: [41, 41],
                                            shadowAnchor: [13, 41],
                                            popupAnchor: [1, -28],
                                            className: _iconClass || 'custom-marker-dot'
                                        }),
                                        _popup = markers[n].popup;

                                    var hireoIcon = L.divIcon({
                                            iconAnchor: [0, 0], // point of the icon which will correspond to marker's location
                                            popupAnchor: [0, 0],
                                            className: 'hireo-marker-icon',
                                            html:  '<div class="marker-container">'+
                                                '<div class="marker-card">'+
                                                '<div class="marker-arrow"></div>'+
                                                '</div>'+
                                                '</div>'
                                        }
                                    );

                                    var _marker = L.marker(markers[n].coordinates, {
                                        icon: hireoIcon
                                    }).addTo(map);

                                    if (_popup) {
                                        _marker.bindPopup(_popup);
                                    }
                                }
                            }
                        },
                        error : function (e) {
                            console.log(e);
                        }
                    });
                    // Map option: No options provided
                } else {

                    map = L.map(mapList[i]).setView([0, 0], 1);
                    L.tileLayer('https://api.maptiler.com/maps/voyager/{z}/{x}/{y}.png?key=5vRQzd34MMsINEyeKPIs', {
                        tileSize: 512,
                        zoomOffset: -1,
                        minZoom: 1,
                        closePopupOnClick: true,
                        attribution: "<a href=\"https://www.maptiler.com/copyright/\" target=\"_blank\">&copy; MapTiler</a> <a href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\">&copy; OpenStreetMap contributors</a>",
                        crossOrigin: true
                    }).addTo(map);
                }
            };

            for (var i = 0; i < mapList.length; i++) {
                var n;

                _loop5(i);
            }
        }
    }

    /**
     * Init theme core
     */
    theme.init();

})(jQuery, window);