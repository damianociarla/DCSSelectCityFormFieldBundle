window.select_city_instance = [];
window.select_city = function (countryId, stateId, cityId) {
    var countryElement = document.getElementById(countryId);
    var stateElement = document.getElementById(stateId);
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
        var url = Routing.generate('dcs_form_select_city_form_field_api_states', {'countryId' : countryElement.options[countryElement.selectedIndex].value});
        emptyOptionFromSelect(stateElement);
        emptyOptionFromSelect(cityElement);
        loadJsonData(url, stateElement, 'stateName');
    };

    stateElement.onchange = function () {
        var url = Routing.generate('dcs_form_select_city_form_field_api_cities', {'stateId' : stateElement.options[stateElement.selectedIndex].value});
        emptyOptionFromSelect(cityElement);
        loadJsonData(url, cityElement, 'cityName');
    };
};