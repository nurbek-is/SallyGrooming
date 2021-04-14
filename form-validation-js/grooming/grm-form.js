function checkSelect(field) {
  if ( field.selectedIndex === 0 ) {
    addError(field);
  } else {
    removeError(field);
  }
}
function checkField(field) {
  if (!field.checkValidity()) {
    addError(field);
  } else {
    removeError(field);
  }
}
function addError(field) {
  if (field.previousElementSibling &&
    field.previousElementSibling.className === 'error') {
    // error message already showing
    return;
  }
    const error = document.createElement('div');
    error.innerHTML = field.dataset.errorMsg;
    error.className = 'error';
    field.parentNode.insertBefore(error,field);
}

function removeError(field) {
  if (field.previousElementSibling &&
    field.previousElementSibling.className === 'error') {
    field.previousElementSibling.remove();
  }
}

window.addEventListener('load', function(e) {
  const form  = document.getElementById('ap-form');

  
  const firstNameField = form.firstname;
  firstNameField.dataset.errorMsg = 'First name must be between ' + firstNameField.minLength + ' and ' + firstNameField.maxLength + ' charachters';  ;
  
  const lastNameField = form.lastname;
  lastNameField.dataset.errorMsg = 'Please type in your lastname';
  
  const addressField = form.address;
  addressField.dataset.errorMsg = 'Please type in your address';
  
  const cityNameField = form.city;
  cityNameField.dataset.errorMsg = 'Please type in your city';
  
  const stateNameField = form.state;
  stateNameField.dataset.errorMsg = 'Please type in your city';
  
  const zipCodeField = form.zipcode;
  zipCodeField.dataset.errorMsg = 'Please type in your zipcode';
  
  const phoneNumberField = form.cellphone;
  phoneNumberField.dataset.errorMsg = 'Please type in your phone number in xxx-xxx-xxxx format';
  
  const emailField = form.emailfield;
  emailField.dataset.errorMsg = 'Invalid email.';
  
  const typeOfPetField = form.typepet;
  typeOfPetField.dataset.errorMsg = 'Please choose type of pet from the list.';
  
  const nameOfPetField = form.petname;
  nameOfPetField.dataset.errorMsg = 'Please type in the name of your pet.';
  
  const petBirthDay = form.birthday;
  petBirthDay.dataset.errorMsg = 'Please type in the pet birthday.';
  
  const petBirthMonth = form.birthmonth;
  petBirthMonth.dataset.errorMsg = 'Please type in the pet\'s birth month.';
  
  const petBirthYear = form.birthyear;
  petBirthYear.dataset.errorMsg = 'Please type in the pet\'s birth year';

  
  firstNameField.addEventListener('input', function(e) {
      checkField(firstNameField);
      });

  lastNameField.addEventListener('input', function(e) {
      checkField(lastNameField);
      });
  addressField.addEventListener('input', function(e) {
      checkField(addressField);
  });
  cityNameField.addEventListener('input', function(e) {
      checkField(cityNameField);
  });
  stateNameField.addEventListener('input', function(e) {
      checkField(stateNameField);
  });
  zipCodeField.addEventListener('input', function(e) {
      checkField(zipCodeField);
  });
  phoneNumberField.addEventListener('input', function(e) {
      checkField(phoneNumberField);
  });
  emailField.addEventListener('input', function(e) {
  checkField(emailField);
  });
  typeOfPetField.addEventListener("change", function(e) {
    checkSelect(typeOfPetField);
  });

  petBirthDay.addEventListener('input', function(e) {
    checkField(petBirthDay);
    });

  petBirthMonth.addEventListener('change', function(e) {
    checkField(petBirthMonth);
    });
  petBirthYear.addEventListener('input', function(e) {
    checkField(petBirthYear);
    });

  // neautorSpayed.addEventListener("check", function(e) {
  //   checkSelect(flavor);
  // });

  form.addEventListener('submit', function(e) {
    // Check errors
    checkField(firstNameField);
    checkField(lastNameField);
    checkField(addressField);
    checkField(cityNameField);
    checkField(stateNameField);
    checkField(zipCodeField);
    checkField(phoneNumberField);
    checkField(emailField);
    checkSelect(typeOfPetField);
    checkField(nameOfPetField);
    checkField(petBirthDay);
    checkSelect(petBirthMonth);
    checkField(petBirthYear);

    // If form is invalid, prevent submission
    if (!form.checkValidity()) {
      e.preventDefault();
      alert('Please fix form errors.');
    }
  });
});

for(let checkbox of form.fixing) {
  checkbox.addEventListener('click',function (e) {
    if (checkbox.checkValidity()) {
      alert(checkbox.e.value)
  }
}

// create a looop auto generate date of week dynamically 
let monthOfYear = [January,February,March,April,May,June,July,August,September,October,November,December]
for (let i=1; i<=12; $i++) {
    "<option value='$i'";
     "</option>"; 
     selected";
  }   
}
