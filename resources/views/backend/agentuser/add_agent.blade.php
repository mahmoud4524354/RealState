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

                            <h6 class="card-title">Add Agent </h6>

                            <form id="myForm" method="POST" action="{{ route('store.agent') }}" class="forms-sample"
                                  enctype="multipart/form-data">
                                @csrf


                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Agent Name </label>
                                    <input type="text" name="name" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Agent Email </label>
                                    <input type="email" name="email" class="form-control">
                                </div>


                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Agent Phone </label>
                                    <input type="text" name="phone" class="form-control">
                                </div>


                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Agent Address </label>
                                    <input type="text" name="address" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Agent Password </label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Agent Image </label>
                                    <input type="file" name="photo" class="form-control"
                                           onChange="mainThamUrl(this)">

                                    <img src="" id="agentPhoto">

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
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },


                },
                messages: {
                    name: {
                        required: 'Please Enter Name',
                    },
                    email: {
                        required: 'Please Enter Email',
                    },
                    phone: {
                        required: 'Please Enter Phone',
                    },
                    password: {
                        required: 'Please Enter Password',
                    },


                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });

    </script>


    <script type="text/javascript">
        function mainThamUrl(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#agentPhoto').attr('src', e.target.result).width(80).height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>


@endsection
