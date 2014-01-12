window.select_region_base_url = null;
window.select_city_base_url = null;
window.select_city_instance = [];
window.select_city = function (countryId, regionId, cityId) {
    var countryElement = document.getElementById(countryId);
    var regionElement = document.getElementById(regionId);
    var cityElement = document.getElementById(cityId);

    var loadJsonData = function (url, element, param) {
        var xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var data = JSON.parse(xmlhttp.responseText);
                for (var i in data) {
                    var info = data[i];
                    var option = document.createElement("option");
                    option.text = info[param];
                    option.value = info.id;
                    element.appendChild(option);
                }
            }
        };

        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    };

    var emptyOptionFromSelect = function (element) {
        element.options.length = 1;
    };

    countryElement.onchange = function () {
        var url = window.select_region_base_url.replace("countryId", countryElement.options[countryElement.selectedIndex].value);
        emptyOptionFromSelect(regionElement);
        emptyOptionFromSelect(cityElement);
        loadJsonData(url, regionElement, 'regionName');
    };

    regionElement.onchange = function () {
        var url = window.select_city_base_url.replace("regionId", regionElement.options[regionElement.selectedIndex].value);
        emptyOptionFromSelect(cityElement);
        loadJsonData(url, cityElement, 'cityName');
    };
};