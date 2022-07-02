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
            <form action="#" id="filter">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="job">Job Name</label>
                            <input type="text" class="form-control bg-white" id="job" name="job" placeholder="Ex: Web Developer">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control bg-white" id="location" name="location" placeholder="Ex: Remote">
                        </div>
                    </div>
                    <div class="col-md-2 text-center my-auto ">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="fulltime" name="fulltime">
                            <label class="form-check-label" for="fulltime">Full Time Only</label>
                        </div>
                    </div>
                    <div class="col text-center my-auto">
                        <button class="btn bt-search btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h2 class="font-weight-bold">Job List</h2>
                    </div>
                    <table class="table" id="jobList">
                        <tbody>
                        </tbody>
                    </table>

                    <div class="my-2 text-right">
                        @for ($i=1;$i<=2;$i++)
                            <input id="btn-paginate" type="button" class="btn btn-paginate btn-primary py-1 mx-1" value="{{$i}}" />
                        @endfor
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
            $('#fulltime').prop('indeterminate', true)
            var page = 1;
            var search = false;

            function searchJob(datas) {

                var filters = $(datas).filter(function (i,n){return n.title==='Web Developer'});

                return filters.prevObject;
            }

            function getJobs() {
                $('#jobList tr').remove();

                var url = "http://dev3.dansmultipro.co.id/api/recruitment/positions.json?page="+page;

                var jqxhr = $.getJSON(url, function(res) {
                    var datas = res;
                    if (search) {
                        var data_search_job = searchJob(datas);
                        console.log(data_search_job);
                        datas = data_search_job;
                    }
                    datas.map((data) => {
                        var url_job_detail = '{{ route("jobs.show", ":id") }}';
                        url_job_detail = url_job_detail.replace(':id', data.id);
                        markup = "<tr><td><a class='font-weight-bold fs-20 text-decoration-none' href='"+url_job_detail+"'>" 
                        + data.title + "</a><br><small class='font-weight-normal'>"+data.company+" - <span class='font-weight-bold text-success'>FullTime</span></small></td></tr>";
                        tableBody = $("table tbody");
                        tableBody.append(markup);
                    })
                });
            }

            $('.btn-paginate').click(function() {
                page = $(this).attr("value");

                getJobs();
            });

            $('.bt-search').click(function() {
                var job = $( "#job" ).val();
                var location = $( "#location" ).val();
                var fulltime = $( "#fulltime" ).val();
                search = true;
                getJobs();
            });

            getJobs();
        });
    </script>
@endpush