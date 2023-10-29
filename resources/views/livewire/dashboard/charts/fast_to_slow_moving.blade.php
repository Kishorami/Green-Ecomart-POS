<div class="col-sm-6">
    <!-- BAR CHART -->
    <div class="card card-info">
        <div class="card-header">
            <h4 class="card-title mb-0">Product Fast To Slow Moving</h4>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="fast_to_slow" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
          <!-- /.card-body -->
    </div>
</div>


@push('scripts')
    <script type="text/javascript">
        // Product fast_to_slow Graph

        $(function () {

            var data = @json($fast_to_slow['data']);
            var areaChartData = {
                labels  : @json($fast_to_slow['labels']),
                datasets: [
                {
                    label               : 'Ratio ',
                    backgroundColor     : 'rgba(0, 153, 51,0.9)',
                    borderColor         : 'rgba(0, 153, 51,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : data
                },
                ]
            }

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#fast_to_slow').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            barChartData.datasets[0] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
                tooltips: {
                    callbacks: {
                        footer: function (tooltipItems,data) {
                            var text = 'Sold ' + data['datasets'][tooltipItems[0].datasetIndex]['data'][tooltipItems[0].index].sold + ' in ' + data['datasets'][tooltipItems[0].datasetIndex]['data'][tooltipItems[0].index].days + 'Days';
                            return text;
                        }
                    }
                },              
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            
        })
    </script>
@endpush