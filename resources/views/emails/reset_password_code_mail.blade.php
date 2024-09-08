{{-- for verification thru code --}}
<!DOCTYPE html>
<html>

<head>
  <title>DOST Grind Project</title>
</head>

<body>

  <div class="container-fluid text-center">
    <div class="row d-flex justify-content-center">
      <div class="col-md-6">
        <div class="d-flex align-items-center flex-column my-2">
          <img src="https://region11.dost.gov.ph/images/Logo/DOST_Header.png" class="w-100 mb-3 border-0"
            style="border-width: 0; margin-bottom: 30px;" />
          <h3 class="mt-5">Welcome to SalikLakbay!</h3>
        </div>
        <div>
          <p>This is a one time confirmation code and will expire in five(5) minutes. Your password reset code is <b>{{ $emailData['reset_code'] }}</b>. </p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
  </script>
</body>

</html>