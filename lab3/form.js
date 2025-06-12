
function validateForm(){

    document.getElementById("nameError").innerHTML="";
    document.getElementById("emailError").innerHTML=" " ; 
    document.getElementById("ageError").innerHTML=" "; 
    document.getElementById("passwordError").innerHTML=" "; 
    document.getElementById("resultMessage").innerHTML=""; 



    const name=document.getElementById("Name").value.trim(); 
    const email=document.getElementById("email").value.trim(); 
    const age=document.getElementById("age").value.trim();
    const password=document.getElementById("password").value; 
 
    let isValid = true;

    // Name check
    if (name === "") {
      document.getElementById("nameError").innerHTML = "Name is required.";
      isValid = false;
    }

    // Email check
    if (!email.includes("@") || !email.includes(".")) {
      document.getElementById("emailError").innerHTML = "Enter a valid email.";
      isValid = false;
    }

    // Age check
    if (isNaN(age) || age < 18 || age > 99) {
      document.getElementById("ageError").innerHTML = "Age must be between 18 and 99.";
      isValid = false;
    }

    // Password check
    if (password.length < 6) {
      document.getElementById("passwordError").innerHTML = "Password must be at least 6 characters.";
      isValid = false;
    }

    // Final result
    if (isValid) {
      document.getElementById("resultMessage").innerHTML = "<span class='success'>Form submitted successfully!</span>";
      return true; // allow form submission
    } else {
      return false; // prevent submission
    }
}








