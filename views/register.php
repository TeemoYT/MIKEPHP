
<form action="register" method="post" class=" vh-100 gradient-custom">
  <div class="me-5 py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
              <p class="text-white-50 mb-5">Please enter your FullName and Email and Password!</p>
              <div data-mdb-input-init class="form-outline form-white mb-4">
                <input name="nameUser" type="text" id="nameUser" placeholder="Enter your fullname" class="form-control form-control-lg" />
                <label class="form-label" for="nameUser">FullName</label>
              </div>
              <div data-mdb-input-init class="form-outline form-white mb-4">
                <input name="email" type="email" id="typeEmailX" placeholder="Enter your Email" class="form-control form-control-lg" />
                <label class="form-label" for="typeEmailX">Email</label>
              </div>

              <div data-mdb-input-init class="form-outline form-white mb-4">
                <input name="password" type="password" id="typePasswordX" placeholder="Enter your password" class="form-control form-control-lg" />
                <label class="form-label" for="typePasswordX">Password</label>
              </div>
              <div data-mdb-input-init class="form-outline form-white mb-4">
                <input name="phone" type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" id="typePasswordX" placeholder="Enter your phone number" class="form-control form-control-lg" />
                <label class="form-label" for="typePasswordX">Number Phone</label>
              </div>
              <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit" name="dangky">Register</button>

              

            </div>

            <div>
            <p class="mb-0">You have an account? <a href="/MIKEPHP/login" class="text-white-50 fw-bold">Login</a>
            </p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</form>