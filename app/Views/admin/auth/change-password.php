<?= $this->extend('admin/template/auth') ?>


<?= $this->section('head') ?>
<style>
  .logo {
    /* padding: 2rem 2rem 1rem; */
    font-size: 2rem;
    font-weight: 700;
  }

  #message {
    display: none;
    background: #fff;
    color: #000;
    /* position: relative; */
    padding: 20px;
    /* margin-top: 10px; */
    margin-top: 20px;
    border-radius: 0.25rem;
  }

  #message p {
    padding: 0px 35px;
    /* font-size: 18px; */
  }

  /* Add a green text color and a checkmark when the requirements are right */
  .valid {
    color: green;
  }

  .valid:before {
    position: relative;
    left: -35px;
    content: "✔";
  }

  /* Add a red text color and an "x" when the requirements are wrong */
  .invalid {
    color: red;
  }

  .invalid:before {
    position: relative;
    left: -35px;
    content: "✖";
  }
</style>
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
<div id="auth">

  <div class="row h-100">
    <div class="col-lg-5 col-12">
      <div id="auth-left">
        <div class="logo mb-3">
          <a href="<?= base_url(); ?>">
            <?= setting('company_name', 'test'); ?>
          </a>
        </div>
        <p class="mb-3 fs-4">Change password now, before expired token</p>
        <form action="<?= base_url('change-password'); ?>" method="post">
          <?= csrf_field(); ?>
          <input type="hidden" name="token" value="<?= $token; ?>">
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" required name="password" id="password" class="form-control form-control-xl <?= ($error = validation_show_error('password')) ? 'border-danger text-danger' : ''; ?>" placeholder="New Password">
            <div class="form-control-icon">
              <i class="bi bi-shield-lock"></i>
            </div>
            <?= ($error) ? '<span class="text-danger">' . $error . '</span>' : ''; ?>
          </div>
          <div id="message" class="mb-2">
            <div class="fw-bold mb-2">Password must contain the following:</div>
            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
            <p id="number" class="invalid">A <b>number</b></p>
            <p id="special" class="invalid">A <b>Spesial Char</b></p>
            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
          </div>

          <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" required name="confirm_password" id="confirm_password" class="form-control form-control-xl <?= ($error = validation_show_error('confirm_password')) ? 'border-danger text-danger' : ''; ?>" placeholder="Confirm Password">
            <div class="form-control-icon">
              <i class="bi bi-shield-lock"></i>
            </div>
            <?= ($error) ? '<span class="text-danger">' . $error . '</span>' : ''; ?>
          </div>
          <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send</button>
        </form>
        <div class="text-center mt-5 text-lg fs-5">
          <p class='text-gray-600'>Remember your account? <a href="<?= base_url('login'); ?>" class="font-bold">Log in</a>.
          </p>
        </div>
      </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
      <div id="auth-right">

      </div>
    </div>
  </div>

</div>
<?= $this->endSection('content') ?>


<?= $this->section('script') ?>
<script>
  var myInput = document.getElementById("password");
  var confirmPassword = document.getElementById("confirm_password");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var special = document.getElementById("special");
  var length = document.getElementById("length");


  function checkConfirmPassword() {
    const parentConfirmPassword = confirmPassword.parentElement;

    // console.log(parentConfirmPassword);
    // HTMLCollection
    // console.log(parentConfirmPassword.children);
    // last Element
    // console.log(parentConfirmPassword.lastElementChild);

    // NodeList
    // console.log(parentConfirmPassword.childNodes);

    if (confirmPassword.value == '') {
      if (parentConfirmPassword.children.length > 2) {
        parentConfirmPassword.removeChild(parentConfirmPassword.lastElementChild)
      }
    }

    if (confirmPassword.value != '') {
      if (myInput.value != confirmPassword.value) {
        confirmPassword.classList.add("border-danger");
        confirmPassword.classList.add("text-danger");

        const spanError = document.createElement('span');
        spanError.classList.add('text-danger');
        spanError.innerText = 'Password and Confirm Password note same';

        if (parentConfirmPassword.children.length == 2) {
          parentConfirmPassword.append(spanError);
        }

      } else {
        confirmPassword.classList.remove("border-danger");
        confirmPassword.classList.remove("text-danger");

        if (parentConfirmPassword.children.length > 2) {
          parentConfirmPassword.removeChild(parentConfirmPassword.lastElementChild)
        }
      }
    }

  }

  confirmPassword.onkeyup = function() {
    checkConfirmPassword();
  }

  // When the user clicks on the password field, show the message box
  myInput.onfocus = function() {
    checkConfirmPassword();
    document.getElementById("message").style.display = "block";
  }

  // When the user clicks outside of the password field, hide the message box
  myInput.onblur = function() {
    checkConfirmPassword();
    document.getElementById("message").style.display = "none";
  }

  // When the user starts to type something inside the password field
  myInput.onkeyup = function() {
    checkConfirmPassword();

    var parentMyInput = myInput.parentElement;

    if (myInput.value == '') {
      if (parentMyInput.children.length > 2) {
        parentMyInput.removeChild(parentMyInput.lastElementChild)
      }
    }

    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if (myInput.value.match(lowerCaseLetters)) {
      letter.classList.remove("invalid");
      letter.classList.add("valid");
    } else {
      letter.classList.remove("valid");
      letter.classList.add("invalid");
    }

    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if (myInput.value.match(upperCaseLetters)) {
      capital.classList.remove("invalid");
      capital.classList.add("valid");
    } else {
      capital.classList.remove("valid");
      capital.classList.add("invalid");
    }

    // Validate numbers
    var numbers = /[0-9]/g;
    if (myInput.value.match(numbers)) {
      number.classList.remove("invalid");
      number.classList.add("valid");
    } else {
      number.classList.remove("valid");
      number.classList.add("invalid");
    }

    var specialChar = /[^\w]/g;
    if (myInput.value.match(specialChar)) {
      special.classList.remove("invalid");
      special.classList.add("valid");
    } else {
      special.classList.remove("valid");
      special.classList.add("invalid");
    }

    // Validate length
    if (myInput.value.length >= 8) {
      length.classList.remove("invalid");
      length.classList.add("valid");
    } else {
      length.classList.remove("valid");
      length.classList.add("invalid");
    }
  }
</script>
<?= $this->endSection('script') ?>