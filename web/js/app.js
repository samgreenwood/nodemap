$(document).ready(function() {
    var openwindow = null;
    var mapNodes = [];
    var mapLinks = [];

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: {
            lat: -34.9285,
            lng: 138.6007
        }
    });

    $.getJSON('/api/nodes', function(nodes) {
        $.each(nodes, function(index, node) {
            var marker = new google.maps.Marker({
                position: {
                    lat: node.coordinates.lat,
                    lng: node.coordinates.lng
                },
                nodeid: node.id,
                title: node.name,
                status: node.status,
            });

            mapNodes.push(marker);

            if (node.status == 'online') {
                if (node.accessPoint) {
                    marker.setIcon('/img/mm_20_blue.png');
                } else {
                    marker.setIcon('/img/mm_20_green.png');
                }
            } else if (node.status == 'inbuild') {
                marker.setIcon('/img/mm_20_orange.png');
            } else if (node.status == 'potential') {
                marker.setIcon('/img/mm_20_gray.png');
            } else {
                marker.setIcon('/img/mm_20_red.png');
            }

            if(node.status == 'online' || node.status == 'inbuild') {
                marker.setMap(map);
            }

            var infowindow = new google.maps.InfoWindow({
                content: node.name
            });

            marker.addListener('click', function() {
                if (openwindow) openwindow.close();
                openwindow = infowindow;
                infowindow.open(map, marker);

                $('#nodedb').attr('src', "https://members.air-stream.wan/node/shownode/id/" + marker.nodeid);
            });
        });
    });

    $.getJSON('/api/links', function(links) {

        var greyLine = {
            path: 'M 0,-1 0,1',
            strokeOpacity: 1,
            scale: 2,
            strokeColor: 'grey'
        };

        var yellowLine = {
            path: 'M 0,-1 0,1',
            strokeOpacity: 1,
            scale: 2,
            strokeColor: '#F1C32F'
        };

        $.each(links, function(index, link) {
            if (link.source.status != 'offline' && link.destination.status != 'offline') {
                var googleLink = new google.maps.Polyline({
                    path: [{
                        lat: link.source.coordinates.lat,
                        lng: link.source.coordinates.lng
                    }, {
                        lat: link.destination.coordinates.lat,
                        lng: link.destination.coordinates.lng
                    }],
                    geodesic: false,
                    strokeColor: null,
                    icons: null,
                    strokeOpacity: 0,
                });

                if (link.source.status == 'potential' || link.destination.status == 'potential') {
                    googleLink.icons = [{
                        icon: greyLine,
                        offset: '0',
                        repeat: '10px'
                    }];
                } else if (link.source.status == 'inbuild' || link.destination.status == 'inbuild') {
                    googleLink.icons = [{
                        icon: yellowLine,
                        offset: '0',
                        repeat: '10px'
                    }];
                } else {
                    googleLink.strokeOpacity = 0.6;

                    if (link.type == 'BB') {
                        googleLink.strokeColor = '#67D768';
                    } else {
                        googleLink.strokeColor = '#095FFB';
                    }
                }

                googleLink.nodeStatus = {
                    source: link.source.status,
                    destination: link.destination.status,
                };

                if(link.source.status != 'potential' && link.destination.status != 'potential') {
                    googleLink.setMap(map);
                }

                mapLinks.push(googleLink)
            }

        });

        $('.node-toggle').change(function() {
            var showStatus = [];

            $('.node-toggle:checked').each(function(i, item) {
                showStatus.push($(item).val());
            });

            $.each(mapNodes, function(i, node) {
                if (showStatus.indexOf(node.status) != -1) {
                    node.setMap(map);
                } else {
                    node.setMap(null);
                }
            });

            $.each(mapLinks, function(i, link) {
                if (showStatus.indexOf(link.nodeStatus.source) != -1 && showStatus.indexOf(link.nodeStatus.destination) != -1) {
                    link.setMap(map);
                } else {
                    link.setMap(null);
                }
            });

        });

        $('#nodedb').on('load', function() {
            $(this).css('height', $(document).height() - 350);
        });

    });

});