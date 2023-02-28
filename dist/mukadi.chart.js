var mukadiChart = (function (Chart) {
    'use strict';

    var rbrace = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/;

    function toCamelCase (str) {
        return str
            .replace(/\-(.)/g, function($1) { return $1.toUpperCase(); })
            .replace(/\-/g, '')
            .replace(/^(.)/, function($1) { return $1.toLowerCase(); })
        ;
    }

    function _data(el, name) {
        var v;
        if(el.dataset !== undefined) {
            v = el.dataset[toCamelCase(name)];
        }else {
            v = el.getAttribute("data-"+name);
        }

        return rbrace.test(v)? JSON.parse(v) : v;
    }

    function start(el) {
        var charts = [];

        var containers = el.querySelectorAll('.mukadi_chartJs_container');

        for(var i = 0; i < containers.length; i++) {
            var div = containers[i];

            var el$1 = div.firstChild;
            var config = {
                type: _data(div, 'chart-type'),
                data: {
                    labels: _data(div, 'labels'),
                    datasets: _data(div, 'datasets')
                },
                options: _data(div, 'options')
            };

            charts.push(new Chart(el$1, config));
        }
    }

    window.onload = function () {
        start(document);
    };

    var index = {
        start: start
    };

    return index;

})(Chart);
