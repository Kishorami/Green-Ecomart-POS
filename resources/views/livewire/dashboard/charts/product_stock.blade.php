

    <div class="col-sm-6">
        <!-- BAR CHART -->
        <div class="card card-success">
            <div class="card-header">
                <h4 class="card-title mb-0">Product Stock</h4>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="product_stock" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>




@push('scripts')

    <script type="text/javascript">
    // Product Stock Graph

        $(function () {

            var areaChartData = {
                labels  : <?php echo json_encode($product_stock['labels']); ?>,
                datasets: [
                    {
                    label               : 'Stock ',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : <?php echo json_encode($product_stock['data']); ?>
                    },
                ]
            }

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#product_stock').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            barChartData.datasets[0] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

                
        })

    </script>

@endpush