<section id="facts" class="facts-area dark-bg">
    <div class="container">
        <div class="facts-wrapper">
            <div class="row">
                <div class="col-md-6 col-sm-6 ts-facts">
                    <div class="ts-facts-img">
                        <img loading="lazy" src="{{ asset('images/icon-image/submit.png') }}" alt="facts-img">
                    </div>
                    <div class="ts-facts-content">
                        <h2 class="ts-facts-num"><span class="counterUp" data-count="{{ countSubmittedInnovations() }}">0</span></h2>
                        <h3 class="ts-facts-title">Submitted Innovations</h3>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 ts-facts mt-5 mt-sm-0">
                    <div class="ts-facts-img">
                        <img loading="lazy" src="{{ asset('images/icon-image/approved.png') }}" alt="facts-img">
                    </div>
                    <div class="ts-facts-content">
                        <h2 class="ts-facts-num"><span class="counterUp" data-count="{{ countApprovedInnovations() }}">0</span></h2>
                        <h3 class="ts-facts-title">Approved Innovations</h3>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
