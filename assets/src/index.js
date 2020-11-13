import Chart from 'chart.js'

let rbrace = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/

function toCamelCase (str) {
    return str
        .replace(/\-(.)/g, function($1) { return $1.toUpperCase(); })
        .replace(/\-/g, '')
        .replace(/^(.)/, function($1) { return $1.toLowerCase(); })
    ;
}

function _data(el, name) {
    let v;
    if(el.dataset !== undefined) {
        v = el.dataset[toCamelCase(name)];
    }else {
        v = el.getAttribute("data-"+name);
    }

    return rbrace.test(v)? JSON.parse(v) : v;
}

function start(el) {
    let charts = []

    let containers = el.querySelectorAll('.mukadi_chartJs_container')

    for(let i = 0; i < containers.length; i++) {
        let div = containers[i];

        let id = _data(div, 'target');
        let config = {
            type: _data(div, 'chart-type'),
            data: {
                labels: _data(div, 'labels'),
                datasets: _data(div, 'datasets')
            },
            options: _data(div, 'options')
        }

        charts[id] = new Chart(document.getElementById(id), config)
    }
}

start(document)

export default {
    start
}