@extends('student.layout')

@section('content')

<!-- Modal -->
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
                    <table class="table table-bordered table-striped">
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
    $(document).ready(function (){
        //GET method AJAX
        fetchstudent();
        function fetchstudent()
        {
            $.ajax({
                    type:"GET",
                    url:"/fetch-students",
                    datatype: "jason",
                    success: function(response)
                    {
                        //console.log(response.students);
                        $('tbody').html("");
                        $.each(response.students, function (key ,  item){
                                $('tbody').append(
                                    '<tr>\
                                    <td>'+item.id+'</td>\
                                    <td>'+item.name+'</td>\
                                    <td>'+item.email+'</td>\
                                    <td>'+item.phone+'</td>\
                                    <td>'+item.course+'</td>\
                                    <td><button type="button" value="'+item.id+'" class=" edit_student btn btn-primary btn-sm">  Edit</button></td>\
                                    <td><button type="button" value="'+item.id+'" class="delete_student btn btn-danger btn-sm">Delete</button></td>\
                                    </tr>'

                                );
                            });
                    }
            });
        }

        // POST method AJAX
        $(document).on('click','.add_student',function(e){
                e.preventDefault();
                var data = {
                    'name' :$('.name').val(),
                    'email' :$('.email').val(),
                    'phone' :$('.phone').val(),
                    'course' :$('.course').val(),
                    
                }
                // console.log(data);
                
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                $.ajax({
                    type:"POST",
                    url:"/students",
                    data: data,
                    datatype: "jason",
                    success: function(response){
                        // console.log(response);
                        if(response.status == 400)
                        {
                            $('#saveform.errlist').html("");
                            $('#saveform.errlist').addClass("alert alert-danger")
                            $.each(response.errors, function (key ,  err_values){
                                $('#saveform.errlist').append('<li>'+err_values+'</li>');
                            });
                        }
                        else{
                            $('#saveform.errlist').html("");

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