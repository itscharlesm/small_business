<div class="modal fade" id="employeeLoginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">User Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <div class="d-flex justify-content-center align-items-center mt-3">
                <a href="/auth/google/redirect"
                    class="d-flex justify-content-center align-items-center btn btn-white text-white shadow rounded"
                    style="background-color: #4385f4">
                    <i class="fab fa-google mr-2 text-white"></i>
                    Sign in with Google
                </a>
            </div> --}}
            <form method="POST" action="{{ action('App\Http\Controllers\LoginController@login') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="col-12 mb-3">
                        <label for="usr_email">E-Mail</label>
                        <input class="form-control" type="email" name="usr_email" id="usr_email" placeholder="email"
                            required />
                        <label for="usr_password">Password</label>
                        <input class="form-control" type="password" name="usr_password" id="usr_password"
                            placeholder="Password" required />
                    </div>
                    <div class="col-12 mb-3">
                        {{-- {!! NoCaptcha::renderJs() !!} --}}
                        {{-- {!! NoCaptcha::display() !!} --}}
                    </div>
                    <div class="col-12 mb-3">
                        <a style="color:green" title="Forgot Password" href="javascript:void(0)" data-toggle="modal"
                            data-target="#forgotPasswordModal" target="_BLANK" data-dismiss="modal"
                            rel="noopener noreferrer">
                            Forgot Password?
                        </a>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><span class="fa fa-key"></span> Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ action('App\Http\Controllers\UserController@forgotPassword') }}">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Forgot Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="usr_email">E-Mail *</label>
                        <input class="form-control" type="email" name="usr_email" id="usr_email" placeholder="E-mail"
                            required />
                    </div>
                    <div class="col-12 mb-3">
                        {{-- {!! NoCaptcha::renderJs() !!} --}}
                        {{-- {!! NoCaptcha::display() !!} --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
