@extends('student.layout')

@section('content')

<!--AddStudentModal Modal -->
<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul id="saveform.errlist"></ul>

                <div class="form-group mb-3">
                    <label for="">Name</label>
                    <input type="text" class="name form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Email</label>
                    <input type="text" class="email form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone</label>
                    <input type="text" class="phone form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Course</label>
                    <input type="text" class="course form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add_student ">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- end add student modal -->

<!-- EditStudentModal -->
<div class="modal fade" id="EditStudentMOdal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul id="updateform_errlist"></ul>
                <!-- id to take student id from data -->
                <input type="hidden" id="edit_stud_id">

                <div class="form-group mb-3">
                    <label for="">Name</label>
                    <input type="text" id="edit_name" class="name form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Email</label>
                    <input type="text" id="edit_email" class="email form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone</label>
                    <input type="text" id="edit_phone" class="phone form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Course</label>
                    <input type="text" id="edit_course" class="course form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary update_student ">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- end EditStudentMOdal -->
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">


            <div id="success_message"></div>
            <div class="card">
                <div class="card-header">
                    <h4> Student Data
                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddStudentModal" class="btn btn-primary float-end btn-sm">Add student</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>PHONE</th>
                                <th>COURSE</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        //GET method AJAX
        fetchstudent();

        function fetchstudent() {
            $.ajax({
                type: "GET",
                url: "/fetch-students",
                datatype: "jason",
                success: function(response) {
                    //console.log(response.students);
                    $('tbody').html("");
                    $.each(response.students, function(key, item) {
                        $('tbody').append(
                            '<tr>\
                                    <td>' + item.id + '</td>\
                                    <td>' + item.name + '</td>\
                                    <td>' + item.email + '</td>\
                                    <td>' + item.phone + '</td>\
                                    <td>' + item.course + '</td>\
                                    <td><button type="button" value="' + item.id + '" class=" edit_student btn btn-primary btn-sm">  Edit </button></td>\
                                    <td><button type="button" value="' + item.id + '" class="delete_student btn btn-danger btn-sm"> Delete </button></td>\
                                    </tr>'

                        );
                    });
                }
            });
        }

        //Edit method AJAX
        $(document).on('click', '.edit_student', function(e) {
            e.preventDefault();
            var stud_id = $(this).val();
            // console.log(stud_id);
            $('#EditStudentMOdal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-student/" + stud_id,
                success: function(response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                    } else {
                        $('#edit_name').val(response.student.name);
                        $('#edit_email').val(response.student.email);
                        $('#edit_phone').val(response.student.phone);
                        $('#edit_course').val(response.student.course);
                        $('#edit_stud_id').val(stud_id);
                        fetchstudent();
                    }
                }
            });
        });

        //Update data using AJAX
        $(document).on('click', '.update_student', function(e) {
            e.preventDefault();
            var stud_id = $('#edit_stud_id').val();
            var data = {
                'name': $('#edit_name').val(),
                'email': $('#edit_email').val(),
                'phone': $('#edit_phone').val(),
                'course': $('#edit_course').val(),

            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "/update-student/" +stud_id,
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $('#updateform_errlist').html("");
                        $('#updateform_errlist').addClass("alert alert-danger")
                        $.each(response.errors, function(key, err_values) {
                            $('#updateform_errlist').append('<li>' + err_values + '</li>');
                        });
                    } else if (response.status == 404) {
                        $('#updateform_errlist').html("");
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)

                    } else {
                        $('#updateform_errlist').html("");
                        $('#success_message').html("");
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)

                        $('#EditStudentModal').modal('hide');
                        fetchstudent();
                    }
                }

            });
        });





        // POST method AJAX
        $(document).on('click', '.add_student', function(e) {
            e.preventDefault();
            var data = {
                'name': $('.name').val(),
                'email': $('.email').val(),
                'phone': $('.phone').val(),
                'course': $('.course').val(),

            }
            // console.log(data);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/students",
                data: data,
                datatype: "jason",
                success: function(response) {
                    // console.log(response);
                    if (response.status == 400) {
                        $('#saveform_errlist').html("");
                        $('#saveform_errlist').addClass("alert alert-danger")
                        $.each(response.errors, function(key, err_values) {
                            $('#saveform_errlist').append('<li>' + err_values + '</li>');
                        });
                    } else {
                        $('#saveform_errlist').html("");
                        $('#success_message').addClass("alert alert-success")
                        $('#success_message').text(response.message)
                        $('#AddStudentModal').modal('hide');
                        $('#AddStudentModal').find('input').val("");
                        fetchstudent(); //calling get function again
                    }

                }
            });

        });


    });
</script>
@endsection