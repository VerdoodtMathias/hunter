navigator.geolocation.getCurrentPosition(function(position) {
    $("#lat").val(position.coords.latitude)
    $("#lng").val(position.coords.longitude);
  });

  function getLocationName() {
        var link = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + "40.714224" + "," + "-73.961452" + "&";
        console.log(link);
        window.jQuery.ajax({
            url: link,
            dataType: "json",
            success: function (data) {
                $(".locationJS").innerHTML(data.results[0].address_components[1].short_name + " " + data.results[0].address_components[0].short_name + ", " + data.results[0].address_components[2].short_name);
            }
        });
    }