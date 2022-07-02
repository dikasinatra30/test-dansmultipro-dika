@extends('layouts.app')

@push('styles')
    <style>
        .fs-20{
            font-size: 20px;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="mb-2">
                <a href="{{ route('jobs.index') }}" class="h5 text-decoration-none font-weight-bold">Back</a>
            </div>
            <div class="card shadow-md">
                {{-- <p class="h5 card-header font-weight-bold fs-20" id="jobTitle"><span id="jobSubTitle" style="font-size: 17px; color: grey" class="font-weight-bold">Tes1</span><br>Data Enginer</p> --}}
                <div id="jobTitle"></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="jobDesc"></div>
                        </div>
                        <div class="col-md-6">

                            <div class="card shadow mb-5">
                                {{-- <p class="card-header font-weight-bold">Company</p> --}}
                                <p id="jobCompany"></p>
                                <div class="card-body">
                                    <div id="companyLogo"></div>
                                    <div id="companyUrl"></div>
                                </div>
                            </div>

                            <div class="card shadow">
                                <p class="card-header font-weight-bold">How To Apply</p>
                                <div class="card-body">
                                    <div id="howToApply"></div>
                                </div>
                            </div>

                        </div>
                    </div>          
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            var id = "{{ $jobId }}";

            function getJobDetail() {
                var url_job_detail = "http://dev3.dansmultipro.co.id/api/recruitment/positions/"+id;
                $.getJSON(url_job_detail, function(data) {
                    console.log(data);
                    var title = "<p class='h5 card-header font-weight-bold fs-20'><span style='font-size: 17px; color: grey' class='font-weight-bold'>"+data.type+" / "+data.location+"</span><br>"+data.title+"</p>";
                    var company = "<p class='card-header font-weight-bold'>"+data.company+"</p>"
                    var companyLogo = "<img src='"+data.company_logo+"' class='img-fluid' />"
                    var companyUrl = "<a href='"+data.company_url+"'>"+data.company_url+"</a>"
                    
                    $("#jobTitle").append(title);
                    $("#jobDesc").append(data.description);
                    $("#jobCompany").append(company);
                    $("#companyLogo").append(companyLogo);
                    $("#companyUrl").append(companyUrl);
                    $("#howToApply").append(data.how_to_apply);
                });
            }

            getJobDetail();
        });
    </script>
@endpush