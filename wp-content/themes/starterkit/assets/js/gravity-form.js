// normal input field event
var field =  document.querySelectorAll('.material-style .gform_wrapper div.gfield input, .material-style .gform_wrapper div.gfield textarea, .material-style  .gform_validation_error div.gfield input');

for (var i = 0, len = field.length; i < len; i++) {
   // add class to  parent element on focus event 
   field[i].addEventListener('focus', function () {
      this.closest(".gfield").classList.add('focused');
   })
   // add   or remove  focused   class to  parent element on blur  event 
   field[i].addEventListener('blur', function () {
      if(this !== null && this.value !== ""){
         this.closest(".gfield").classList.add('focused');
      }
     else{
         this.closest(".gfield").classList.remove('focused');
      }
   })
   // add   focused  class to parent element if the input field is not empty
   if(field[i].value !== ''){
      field[i].closest(".gfield").classList.add('focused');
   }
   else{
      field[i].closest(".gfield").classList.remove('focused');
   }
}
// complex field event 
var complexField =  document.querySelectorAll('.material-style .gform_wrapper .ginput_complex span input, .material-style .gform_wrapper .ginput_complex  .ginput_full input');
for (var i = 0, len = complexField.length; i < len; i++) {
   // add focused class to complex field   parent element on focus event 
   complexField[i].addEventListener('focus', function () {
     this.closest("span").classList.add('focused');
   })
   // add or  remove focused  class  to complex field  parent element  on blur event
   complexField[i].addEventListener('blur', function () {
        if(this !== null && this.value === ""){
            this.closest("span").classList.remove('focused');
         }else{
            this.closest("span").classList.add('focused');
         }
   })
}
// add class  to date and select field  parent element  on default state and blur event 
const dateField = document.querySelectorAll(' .material-style .gform_wrapper div.gfield input.datepicker, .material-style .gform_wrapper div.gfield select')
for (var i = 0, len = dateField.length; i < len; i++) {
   dateField[i].closest('.gfield').classList.add('focused');
   dateField[i].addEventListener('blur', function () {
      this.closest('.gfield').classList.add('focused');    
   })
}


// focus and blur events trigger when the  page is loaded after   submitting form 
jQuery(document).on('gform_page_loaded', function(event, form_id, current_page){
    // select2 initialization
    var select = $('select').not('.woocommerce .checkout .form-row select, .woocommerce-shipping-totals  select');
    select.select2({
        minimumResultsForSearch: Infinity
    });

   // Normal input field focus and blur event
   var field =  document.querySelectorAll('.material-style .gform_wrapper div.gfield input, .material-style .gform_wrapper div.gfield textarea,  .material-style .gform_validation_error div.gfield input');

   for (var i = 0, len = field.length; i < len; i++) {
      
      field[i].addEventListener('focus', function () {
         this.closest(".gfield").classList.add('focused');
      })
      field[i].addEventListener('blur', function () {
         if(this !== null && this.value === ""){
            this.closest(".gfield").classList.remove('focused');
         }
      else{
            this.closest(".gfield").classList.add('focused');
         }
         
      })
      if(field[i].value !== ''){
         field[i].closest(".gfield").classList.add('focused');
      }
   }

   //  focus and blur event for input field inside  complex container 
   var complexField =  document.querySelectorAll('.material-style  .gform_wrapper .ginput_complex span input,  .material-style .ginput_complex  .ginput_full  input, .material-style .ginput_complex  .ginput_left  input, .material-style .ginput_complex  .ginput_right  input');
  
   for (var i = 0, len = complexField.length; i < len; i++) {
      // check if the input field  has value  and add/remove focused class
      if(complexField[i] !== null && complexField[i].value === ""){
         complexField[i].closest("span").classList.remove('focused');
      }else{
         complexField[i].closest("span").classList.add('focused');
         
      }
      // focus event
      complexField[i].addEventListener('focus', function () {
         this.closest("span").classList.add('focused');
      })
      // blur event
      complexField[i].addEventListener('blur', function () {
         if(this !== null && this.value === ""){
               this.closest("span").classList.remove('focused');
         }else{
            this.closest("span").classList.add('focused');
         }
      })
   }
   //  add focused  class to  select and datepicker field  by defualt
  var defualtField = document.querySelectorAll('.material-style .gform_wrapper div.gfield input.datepicker, .material-style .gform_wrapper div.gfield select')
   for (var i = 0, len = defualtField.length; i < len; i++) {
      defualtField[i].closest('.gfield').classList.add('focused');
      //add focused  class to  select and datepicker field  on blur event
      defualtField[i].addEventListener('blur', function () {
         this.closest('.gfield').classList.add('focused');    
      })
   }
 });

