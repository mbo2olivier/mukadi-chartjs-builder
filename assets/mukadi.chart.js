jQuery(document).ready(function(){
    var charts = {};
    jQuery('.mukadi_chartJs_container').each(function(){
        var id = jQuery(this).data('target');
        var config = {
            type: jQuery(this).data('chart-type'),
            data: {
                labels: jQuery(this).data('labels'),
                datasets: jQuery(this).data('datasets')
            },
            options: jQuery(this).data('options')
        };
        var chart = new Chart(jQuery("#"+id),config);
        charts[id]=chart;
    });
    window.mukadi_charts={
        get: function(id){
            return charts[id];
        }
    }
});