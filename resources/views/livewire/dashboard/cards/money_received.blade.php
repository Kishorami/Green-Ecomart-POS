<a href="{{ route('sell_report') }}">
<div class="col-lg-12">
    <div class="card text-white bg-success">
        <div class="card-body">
            <blockquote class="card-bodyquote mb-0">
                <div class="row d-flex justify-content-between">
                    <div class="ml-2" style="font-size: 2rem">
                        <i class="mdi mdi-cash-multiple"></i>
                    </div>
                    <div class="mr-2">
                        <strong style="font-size: 1rem">Today Total Received (Sales)</strong>
                        <h3 style="color:white;text-align: right;">{{ number_format((float)($today_total_received), 2, '.', '') }} BDT</h3>
                    </div>
                </div>
            </blockquote>
        </div>
    </div> <!-- end card-box-->
</div>
</a>
