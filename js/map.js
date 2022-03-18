    // Initialize and add the map

    function initMap() {
      // The location of Uluru
      
      let latitude = document.getElementById("lat").innerHTML;
      let longtitude = document.getElementById("log").innerHTML;

      const uluru = { lat: Number(latitude), lng: Number(longtitude) };
      // The map, centered at Uluru
      const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 18,
        center: uluru,
      });
      const geocoder = new google.maps.Geocoder();
      const infowindow = new google.maps.InfoWindow();

      geocodeLatLng(geocoder, map, infowindow);

      document.getElementById("submit").addEventListener("click", () => {
        geocodeLatLng(geocoder, map, infowindow);
      });
      // The marker, positioned at Uluru
      const marker = new google.maps.Marker({
        position: uluru,
        map: map,
      });
    }


    function geocodeLatLng(geocoder, map, infowindow) {
      const input = document.getElementById("latlng").value;
      const latlngStr = input.split(",", 2);
      const latlng = {
        lat: parseFloat(latlngStr[0]),
        lng: parseFloat(latlngStr[1]),
      };

      geocoder
        .geocode({ location: latlng })
        .then((response) => {
          if (response.results[0]) {
            map.setZoom(19);

            const marker = new google.maps.Marker({
              position: latlng,
              map: map,
            });

            infowindow.setContent(response.results[0].formatted_address);
            document.getElementById(
              "result"
            ).innerHTML = `<h4 style="text-align:left;">Address: ${response.results[0].formatted_address}</h4>`;
            infowindow.open(map, marker);
          } else {
            window.alert("No results found");
          }
        })
        .catch((e) => window.alert("Geocoder failed due to: " + e));
    }














