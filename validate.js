// Create a function validateInput to validate input
function validateInput(input, minLength, maxLength, regex, errorElement, errorMsgLength, errorMsgInvalid) {
    if (input.value.length < minLength || input.value.length > maxLength) {
      errorElement.innerText = errorMsgLength;
    } else if (!regex.test(input.value)) {
      errorElement.innerText = errorMsgInvalid;
    } else {
      errorElement.innerText = '';
    }
  }

  function validatePurchaseDate(purchaseDateInput, yearInput, errorElement) {
    const purchaseDate = new Date(purchaseDateInput.value);
    const purchaseYear = purchaseDate.getFullYear();
    const modelYear = parseInt(yearInput.value, 10);
  
    //If purchase year < model year, output wrong message
    if (purchaseYear < modelYear) {
      errorElement.innerText = 'The purchase date needs to be later than the model year!';
    } else {
      errorElement.innerText = '';
    }
  }
  
  //Add event listener to show wrong message imediately
  document.addEventListener('DOMContentLoaded', function () {
    const brandInput = document.getElementById('brand');
    const modelInput = document.getElementById('model');
    const yearInput = document.getElementById('year');
    const brandError = document.getElementById('brand-error');
    const modelError = document.getElementById('model-error');
    const yearError = document.getElementById('year-error');
    const dateOfPurchaseInput = document.getElementById('date_of_purchase');
    const dateOfPurchaseError = document.getElementById('date_of_purchase-error'); 
  
    const brandModelRegex = /^[a-zA-Z0-9 ]{2,20}$/;
    const yearRegex = /^(19[0-9]{2}|200[0-9]|201[0-9]|202[0-5])$/;
  
    //validate brand input, the length should be longer than 2 and shorter than 20
    //Don't have any special characters
    brandInput.addEventListener('input', () => {
      validateInput(
        brandInput,
        2,
        20,
        brandModelRegex,
        brandError,
        'The length of brand should be 2-20 characters long.',
        'Special characters not accepted!'
      );
    });

    dateOfPurchaseInput.addEventListener('input', () => {
        validatePurchaseDate(dateOfPurchaseInput, yearInput, dateOfPurchaseError);
      });
  
    //Check the input of model, the length should be longer than 2 and shorter than 20
    //Don't have any special characters
    modelInput.addEventListener('input', () => {
      validateInput(
        modelInput,
        2,
        20,
        brandModelRegex,
        modelError,
        'The length of model should be 2-20 characters long.',
        'Special characters not accepted!'
      );
    });
  
    //Check the input of year, the year should between 1900 and 2025
    yearInput.addEventListener('input', () => {
      validateInput(
        yearInput,
        4,
        4,
        yearRegex,
        yearError,
        'The year needs to start from 1900 to 2025!',
        'The year needs to start from 1900 to 2025!'
      );
    });
  });