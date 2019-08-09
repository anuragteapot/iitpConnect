<?php

echo '<h4 class="d-flex justify-content-between align-items-center mb-3">
    <h5>Overall Details Hostel Wise</h5>
</h4>
<ul class="list-group mb-3">
    <li class="list-group-item d-flex justify-content-between lh-condensed" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <div>
            <h6 class="my-0">Damaged Rooms</h6>
            <div class="collapse" id="collapseExample">
                <br>
                <div style="float:left;">
                    <h3 style="margin-left:3px;"><a href="#"><span class="badge badge-primary">123</span></a></h3>
                </div>
                <div style="float:left;">
                    <h3 style="margin-left:3px;"><span class="badge badge-primary">123</span></h3>
                </div>
                <div style="float:left;">
                    <h3 style="margin-left:3px;"><span class="badge badge-primary">123</span></h3>
                </div>
            </div>
        </div>
        <span class="text-muted">$12</span>
    </li>
    <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div>
            <h6 class="my-0">Single Occupants Rooms</h6>
        </div>
        <span class="text-muted">$8</span>
    </li>
    <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div>
            <h6 class="my-0">Ready to occupy</h6>
        </div>
        <span class="text-muted">$5</span>
    </li>
    <li class="list-group-item d-flex justify-content-between bg-light">
        <div class="text-success">
            <h6 class="my-0">Promo code</h6>
            <small>EXAMPLECODE</small>
        </div>
        <span class="text-success">-$5</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <span>Total (USD)</span>
        <strong>$20</strong>
    </li>
</ul>';


?>
