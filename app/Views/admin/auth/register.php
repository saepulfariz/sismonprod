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
        <p class="mb-3 fs-3">Input your data to register to our website.</p>

        <form action="<?= base_url('register'); ?>" method="post">
          <?= csrf_field(); ?>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" required class="form-control form-control-xl <?= ($error = validation_show_error('name')) ? 'border-danger text-danger' : ''; ?>" name="name" id="name" onkeyup="$('#username').val(createUsername(this.value))" autofocus="" placeholder="Full Name" value="<?= old('name'); ?>">
            <div class="form-control-icon">
              <i class="bi bi-person"></i>
            </div>
            <?= ($error) ? '<span class="text-danger">' . $error . '</span>' : ''; ?>
          </div>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="email" class="form-control form-control-xl <?= ($error = validation_show_error('email')) ? 'border-danger text-danger' : ''; ?>" name="email" id="email" placeholder="Email" value="<?= old('email'); ?>">
            <div class="form-control-icon">
              <i class="bi bi-envelope"></i>
            </div>
            <?= ($error) ? '<span class="text-danger">' . $error . '</span>' : ''; ?>
          </div>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" required class="form-control form-control-xl <?= ($error = validation_show_error('username')) ? 'border-danger text-danger' : ''; ?>" name="username" id="username" placeholder="Username" value="<?= old('username'); ?>">
            <div class="form-control-icon">
              <i class="bi bi-person"></i>
            </div>
            <?= ($error) ? '<span class="text-danger">' . $error . '</span>' : ''; ?>
          </div>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" required class="form-control form-control-xl <?= ($error = validation_show_error('password')) ? 'border-danger text-danger' : ''; ?>" name="password" id="password" placeholder="Password">
            <div class="form-control-icon">
              <i class="bi bi-shield-lock"></i>
            </div>
            <?= ($error) ? '<span class="text-danger">' . $error . '</span>' : ''; ?>
            <div id="message" class="mt-2 ">
              <div class="fw-bold mb-2">Password must contain the following:</div>
              <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
              <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
              <p id="number" class="invalid">A <b>number</b></p>
              <p id="special" class="invalid">A <b>Spesial Char</b></p>
              <p id="length" class="invalid">Minimum <b>8 characters</b></p>
            </div>
          </div>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" required class="form-control form-control-xl <?= ($error = validation_show_error('confirm_password')) ? 'border-danger text-danger' : ''; ?>" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
            <div class="form-control-icon">
              <i class="bi bi-shield-lock"></i>
            </div>
            <?= ($error) ? '<span class="text-danger">' . $error . '</span>' : ''; ?>
          </div>
          <?php if (setting('google_recaptcha_enabled') == '1') : ?>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="form-group">
              <div class="g-recaptcha" data-sitekey="<?php echo setting('google_recaptcha_sitekey') ?>"></div>
              <span class="text-danger"><?= validation_show_error('g-recaptcha-response'); ?></span>
            </div>
          <?php endif ?>

          <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
        </form>
        <div class="text-center mt-5 text-lg fs-5">
          <p class='text-gray-600'>Already have an account? <a href="<?= base_url('login'); ?>" class="font-bold">Log
              in</a>.</p>
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
  function createUsername(name) {
    return name.toLowerCase()
      .replace(/ /g, '_')
      .replace(/[^\w-]+/g, '');;
  }

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


  $('#email').on('keyup', function() {
    var elementEmail = $('#email');
    var email = elementEmail.val();
    const parentEmail = elementEmail.parent();
    var et = /[@]/g;
    var titik = /[.]/g;
    if (email.match(et)) {
      $.ajax({
        url: '<?= base_url('ajax-email'); ?>',
        method: 'GET', // POST
        data: {
          email: email
        },
        dataType: 'json', // json
        success: function(data) {
          if (data.result == true) {
            // already use
            // console.log('true');
            elementEmail.addClass('border-danger')
            elementEmail.addClass('text-danger')
            const spanError = document.createElement('span');
            spanError.classList.add('text-danger');
            spanError.innerText = data.message
            if (parentEmail.children().length == 2) {
              parentEmail.append(spanError);
            }
          } else {
            // console.log('false');
            elementEmail.removeClass('border-danger')
            elementEmail.removeClass('text-danger')

            if (parentEmail.children().length > 2) {
              // parentEmail.children().last()
              // parentEmail.remove('span.text-danger');
              // parentEmail.remove(parentEmail.children().last());\
              var parElement = document.getElementById("email").parentElement;
              parElement.removeChild(parElement.lastElementChild)
            }
          }
        }
      });
    }
  })

  $('#username').on('keyup', function() {
    checkUsername();
  })

  $('#name').on('keyup', function() {
    checkUsername();
  })

  function checkUsername() {
    var elementUsername = $('#username');
    var username = elementUsername.val();
    const parentUsername = elementUsername.parent();
    if (username != '') {
      $.ajax({
        url: '<?= base_url('ajax-username'); ?>',
        method: 'GET', // POST
        data: {
          username: username
        },
        dataType: 'json', // json
        success: function(data) {
          if (data.result == true) {
            // already use
            // console.log('true');
            elementUsername.addClass('border-danger')
            elementUsername.addClass('text-danger')
            const spanError = document.createElement('span');
            spanError.classList.add('text-danger');
            spanError.innerText = data.message
            if (parentUsername.children().length == 2) {
              parentUsername.append(spanError);
            }
          } else {
            // console.log('false');
            elementUsername.removeClass('border-danger')
            elementUsername.removeClass('text-danger')

            if (parentUsername.children().length > 2) {
              // parentUsername.children().last()
              // parentUsername.remove('span.text-danger');
              // parentUsername.remove(parentUsername.children().last());\
              var parElement = document.getElementById("username").parentElement;
              parElement.removeChild(parElement.lastElementChild)
            }
          }
        }
      });
    }
  }
</script>
<?= $this->endSection('script') ?>