 // Get the checkbox and button elements
 const checkbox = document.getElementById('myCheckbox');
 const button = document.getElementById('myButton');

 // Add event listener for the checkbox click event
 checkbox.addEventListener('click', function() {
   if (checkbox.checked) {
     // Checkbox is checked, enable the button and change its color
     button.style.backgroundColor = '';
     button.classList.remove('disabled');
     button.classList.add('btn-primary');
   } else {
     // Checkbox is unchecked, disable the button and change its color
     button.style.backgroundColor = 'grey';
     button.classList.remove('btn-primary');
     button.classList.add('disabled');
   }
 });

 // Check the initial state of the checkbox and update the button accordingly
 if (checkbox.checked) {
   button.style.backgroundColor = '';
   button.classList.remove('disabled');
   button.classList.add('btn-primary');
 } else {
   button.style.backgroundColor = 'grey';
   button.classList.remove('btn-primary');
   button.classList.add('disabled');
 }