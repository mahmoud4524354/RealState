@extends('admin.home.master')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <div class="page-content">


        <div class="row profile-body">
            <!-- left wrapper start -->

            <!-- left wrapper end -->
            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Update Site Setting </h6>

                            <form id="myForm" method="POST" action="{{ route('update.site.setting',$setting->id) }}"
                                  class="forms-sample" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">support_phone </label>
                                    <input type="text" name="support_phone" class="form-control"
                                           value="{{ $setting->support_phone }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">company_address </label>
                                    <input type="text" name="company_address" class="form-control"
                                           value="{{ $setting->company_address }}">
                                </div>


                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> email </label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ $setting->email }}">
                                </div>


                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">facebook </label>
                                    <input type="text" name="facebook" class="form-control"
                                           value="{{ $setting->facebook }}">
                                </div>


                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">twitter </label>
                                    <input type="text" name="twitter" class="form-control"
                                           value="{{ $setting->twitter }}">
                                </div>


                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> copyright </label>
                                    <input type="text" name="copyright" class="form-control"
                                           value="{{ $setting->copyright }}">
                                </div>


                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Logo </label>
                                    <input class="form-control" name="logo" type="file" id="image">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> </label>
                                    <img id="showImage" class="wd-80 rounded-circle"
                                         src="{{ asset($setting->logo) }}" alt="profile">
                                </div>


                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>


    <script type="text/javascript">
        $(document).ready(function () {
            $('#image').change(function (e) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });


    </script>

@endsection
