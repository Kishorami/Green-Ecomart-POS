<a href="{{ route('expences') }}">
<div class="col-lg-12">
    <div class="card text-white bg-warning">
        <div class="card-body">
            <blockquote class="card-bodyquote mb-0">
                <div class="row d-flex justify-content-between">
                    <div class="ml-2" style="font-size: 2rem">
                        <i class="mdi mdi-cash-100"></i>
                    </div>
                    <div class="mr-2">
                        <strong style="font-size: 1rem">Expences This Month</strong>
                        <h3 style="color:white;text-align: right;">{{ number_format((float)($expences_this_month), 2, '.', '') }} BDT</h3>
                    </div>
                </div>
            </blockquote>
        </div>
    </div> <!-- end card-box-->
</div>
</a>
