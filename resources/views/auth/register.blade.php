@extends('dashboard')
@section('content')
<main class="register-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h2 class="card-header text-center">Register</h2>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register.custom') }}">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <input type="text" placeholder="id"  id="id" id="id" value="{{ old('id') }}" class="form-control" required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Nama"  name="nama" id="nama" value="{{ old('nama') }}" class="form-control" required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <input type="date" placeholder="BirthDay" name="date" id="date" value="{{ old ('date') }}" class="form-control" required
                                    autofocus>
                                @if ($errors->has('date'))
                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" name="email" id="email" value="{{ old ('email') }}" class="form-control" required
                                    autofocus>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="number" placeholder="Phone" name="phone" id="phone" value="{{ old('phone') }}" class="form-control" required>
                                @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                                <div class="form-group mb-3">
                            </div>
                        <div class="form-group mb-3">
                             <select name="jobs" id="jobs"  class="form-control"  required
                                autofocus>
                                <option value="" disabled selected hidden> Jobs</option>
                                <option value="BackEnd Engineer">BackEnd Engineer</option>
                                <option value="FrontEnd Engineer">FrontEnd Engineer</option>
                                <option value="DevOps Engineer">DevOps Engineer</option>
                                <option value="UI/UX Engineer">UI/UX Engineer</option>
                                <option value="Network Engineer">Network Engineer</option>
                                <option value="Mobile Engineer">Mobile Engineer</option>
                                <option value="Software Quality Engineer">Software Quality Engineer</option>
                            </select> 
                            @if ($errors->has('jobs'))
                             <span class="text-danger">{{ $errors->first('jobs') }}</span>
                            @endif
                        </div>
                            
                        <div class="form-group mb-3">
                            <select  name="skill" id="skills"  class="form-control" required
                            autofocus>
                                <option value="" disabled selected hidden>Skills</option>
                                <option value="Laravel">Laravel</option>
                                <option value="Codeigniter">Codeigniter</option>
                                <option value="Figma">Figma</option>
                                <option value="API">API</option>
                                <option value="Postgresql">Postgresql</option>
                                <option value="Mysql">Mysql</option>
                                <option value="Docker">Docker</option>
                                <option value="Linux">Linux</option>
                                <option value="ReactJS">ReactJS</option>
                                <option value="VueJS">VueJS</option>
                                <option value="Java">Java</option>
                                <option value="Kotlin">Kotlin</option>
                                <option value="Flutter">Flutter</option>
                                <option value="PHP">PHP</option>
                                <option value="JavaScript">JavaScript</option>
                            </select> 
                             @if ($errors->has('skill'))
                                <span class="text-danger">{{ $errors->first('skills') }}</span>
                            @endif
                        </div>

                    </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-register btn-danger btn-block">Uploads</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {

        $(".btn-register").click( function() {

            var nama = $("#nama").val();
            var date = $("#date").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var jobs = $("#jobs").val();
            var skills = $("#skills").val();
            var token = $("meta[name='csrf-token']").attr("content");

            if (nama.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Nama Wajib Diisi !'
                });

            }else if(date.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'UlangTahun Wajib Diisi !'
                });

            } else if(email.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Alamat Email Wajib Diisi !'
                });

            } else if(phone.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Phone Wajib Diisi !'
                });

            }else if(job.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'jobs Wajib Diisi !'
                });

            }else if(skill.length == "") {

                Swal.fire({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'skills Wajib Diisi !'
                });

            }else {

                //ajax
                $.ajax({

                    url: "{{ route('register.custom') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "nama"  : nama,
                        "date"  : date,
                        "email" : email,
                        "phone" : phone,
                        "jobs"   : jobs,
                        "skills" : skills,
                        "_token": token
                    },

                    success:function(response){

                        if (response.success) {

                            Swal.fire({
                                type: 'success',
                                title: 'Register Berhasil!',
                                text: 'silahkan login!'
                            });

                            $("#nama").val('');
                            $("#date").val('');
                            $("#email").val('');
                            $("#phone").val('');
                            $("#jobs").val('');
                            $("#skills").val('');

                        } else {

                            Swal.fire({
                                type: 'error',
                                title: 'Register Gagal!',
                                text: 'silahkan coba lagi!'
                            });

                        }

                        console.log(response);

                    },

                    error:function(response){
                        Swal.fire({
                            type: 'error',
                            title: 'Opps!',
                            text: 'server error!'
                        });
                    }

                })

            }

        });

    });
</script>


