function Chart_template(){
    var self= this;

    this.init= function(){
        
    };

    this.chart_pie = function(element, data_columns, data_color){
        var chart = c3.generate({
            bindto: element, // id of chart wrapper
            data: {
                json: data_columns,
                type: 'pie', // default type of chart
            },
            color: {
                pattern: ['#6fbbff', '#05ffe4', '#ff6f62', '#f9dd7e', '#f1c5d4', '#98df8a', '#cd201f', '#ff9896', '#9467bd', '#c5b0d5', '#8c564b', '#c49c94', '#e377c2', '#f7b6d2', '#7f7f7f', '#c7c7c7', '#bcbd22', '#dbdb8d', '#17becf', '#9edae5']
            },
            legend: {
                show: true, //hide legend
            },
            padding: {
                bottom: 0,
                top: 0
            },
        });
    }

    this.chart_spline = function( element, data_columns){
        var chart = c3.generate({
            bindto: element,
            title: {
              color: '#6fbbff',
            },
            data: {
                x: 'time',
                xFormat: '%Y-%m-%d',
                json: data_columns,
                type: 'spline'
            },
            color: {
                pattern: ['#6fbbff', '#05ffe4', '#ff6f62', '#f9dd7e', '#f1c5d4', '#98df8a', '#cd201f', '#ff9896', '#9467bd', '#c5b0d5', '#8c564b', '#c49c94', '#e377c2', '#f7b6d2', '#7f7f7f', '#c7c7c7', '#bcbd22', '#dbdb8d', '#17becf', '#9edae5']
            },
            axis: {
                x: {
                  type: 'timeseries',
                  tick: {
                    format: '%Y-%m-%d'
                  }
                },
                y: {
                    padding: {top: 50, bottom: 0},
                    tick: {
                        format: function (d) {
                            return (parseInt(d) == d) ? d : null;
                        }
                    }
                },
            },
            legend: {
                show: true,
            },
        });
    }

}

Chart_template= new Chart_template();
$(function(){
    Chart_template.init();
});