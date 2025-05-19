<h3 class="text-center my-4">Personal Information</h3>

<?php

$firstName = htmlspecialchars($personalInformation['first_name']);
$middleName = htmlspecialchars($personalInformation['middle_name']);
$lastName = htmlspecialchars($personalInformation['last_name']);
$gender = htmlspecialchars($personalInformation['sex']);
$birthDate = htmlspecialchars($personalInformation['birthdate']);
$address = htmlspecialchars($personalInformation['address']);
$religion = htmlspecialchars($personalInformation['religion']);
$maritalStatus = htmlspecialchars($personalInformation['marital_status']);
$occupation = htmlspecialchars($personalInformation['occupation']);
$educationalAttainment = htmlspecialchars($personalInformation['educational_attainment'] ?? 'Not Appplicable');
$personalStatement = htmlspecialchars($personalInformation['personal_statement']);

?>

<div class="container py-5">
     <div class="row g-4 justify-content-center">
          <!-- First Name -->
          <div class="col-md-4">
               <label for="firstName" class="form-label">
                    <i class="bi bi-person"></i> First Name
               </label>
               <input type="text" name="firstName" id="firstName" class="form-control shadow-sm" value="<?= $firstName ?>" />
          </div>

          <!-- Middle Name -->
          <div class="col-md-4">
               <label for="middleName" class="form-label">
                    <i class="bi bi-person"></i> Middle Name
               </label>
               <input type="text" name="middleName" id="middleName" class="form-control shadow-sm" value="<?= $middleName ?>" />
          </div>

          <!-- Last Name -->
          <div class="col-md-4">
               <label for="lastName" class="form-label">
                    <i class="bi bi-person"></i> Last Name
               </label>
               <input type="text" name="lastName" id="lastName" class="form-control shadow-sm" value="<?= $lastName ?>" />
          </div>

          <!-- Gender -->
          <div class="col-md-4">
               <label for="gender" class="form-label">
                    <i class="bi bi-gender-ambiguous"></i> Gender
               </label>
               <select name="gender" id="gender" class="form-select shadow-sm">
                    <option value="Male" <?= $gender == 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $gender == 'Female' ? 'selected' : '' ?>>Female</option>
               </select>
          </div>

          <!-- Birth Date -->
          <div class="col-md-4">
               <label for="birthDate" class="form-label">
                    <i class="bi bi-calendar-date"></i> Date of Birth
               </label>
               <input type="date" name="birthDate" id="birthDate" class="form-control shadow-sm" value="<?= $birthDate ?>" />
          </div>

          <!-- Address -->
          <div class="col-md-4">
               <label for="address" class="form-label">
                    <i class="bi bi-house"></i> Address
               </label>
               <input type="text" name="address" id="address" class="form-control shadow-sm" value="<?= $address ?>" />
          </div>

          <!-- Religion -->
          <div class="col-md-4">
               <label for="religion" class="form-label">
                    <i class="bi bi-heart"></i> Religion
               </label>
               <input type="text" name="religion" id="religion" class="form-control shadow-sm" value="<?= $religion ?>" />
          </div>

          <!-- Marital Status -->
          <div class="col-md-4">
               <label for="maritalStatus" class="form-label">
                    <i class="bi bi-heart-fill"></i> Marital Status
               </label>
               <input type="text" name="maritalStatus" id="maritalStatus" class="form-control shadow-sm" value="<?= $maritalStatus ?>" />
          </div>

          <!-- Occupation -->
          <div class="col-md-4">
               <label for="occupation" class="form-label">
                    <i class="bi bi-briefcase"></i> Occupation
               </label>
               <input type="text" name="occupation" id="occupation" class="form-control shadow-sm" value="<?= $occupation ?>" />
          </div>

          <!-- Educational Attainment -->
          <div class="col-md-6">
               <label for="educationalAttainment" class="form-label">
                    <i class="bi bi-mortarboard"></i> Educational Attainment
               </label>
               <input type="text" name="educationalAttainment" id="educationalAttainment" class="form-control shadow-sm" value="<?= $educationalAttainment ?>" />
          </div>

          <!-- Personal Statement -->
          <div class="col-md-6">
               <label for="personalStatement" class="form-label">
                    <i class="bi bi-pencil-square"></i> Personal Statement
               </label>
               <textarea name="personalStatement" id="personalStatement" class="form-control shadow-sm" rows="3"><?= $personalStatement ?></textarea>
          </div>
     </div>
</div>