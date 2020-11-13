var mukadiChart = (function (Chart) {
    'use strict';

    function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

    var Chart__default = /*#__PURE__*/_interopDefaultLegacy(Chart);

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

            var id = _data(div, 'target');
            var config = {
                type: _data(div, 'chart-type'),
                data: {
                    labels: _data(div, 'labels'),
                    datasets: _data(div, 'datasets')
                },
                options: _data(div, 'options')
            };

            charts[id] = new Chart__default['default'](document.getElementById(id), config);
        }
    }

    start(document);

    var index = {
        start: start
    };

    return index;

}(Chart));
