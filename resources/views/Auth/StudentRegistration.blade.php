<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
</head>
<body>

<div class="registration-card">
    <button type="button" class="close-btn" onclick="exitRegistration()">×</button>

    <div class="heading">
        <h1>STUDENT REGISTRATION</h1>
        <p>Create your student account to get started.</p>
    </div>

    <form id="studentRegistrationForm">

        <div class="field-row">
            <div class="field">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter first name" required>
            </div>
            <div class="field">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter last name" required>
            </div>
        </div>

        <div class="field">
            <label for="studentNumber">Student Number</label>
            <input type="text" id="studentNumber" name="studentNumber" placeholder="Enter student number" required>
            <p class="input-hint">Example: 2026-12345-SR-0</p>
        </div>

        <div class="field">
            <label for="course">Course</label>
            <div class="course-dropdown" id="courseDropdown">
                <button type="button" class="course-selected" onclick="toggleCourses()">
                    <span id="selectedCourse">Select your course</span>
                    <span class="course-arrow">▾</span>
                </button>

                <div class="course-options">
                    <div class="course-option" onclick="selectCourse('Bachelor of Technology and Livelihood Education major in Home Economics', 'BTLED-HE')">Bachelor of Technology and Livelihood Education major in Home Economics</div>
                    <div class="course-option" onclick="selectCourse('Bachelor of Science in Accountancy', 'BSA')">Bachelor of Science in Accountancy</div>
                    <div class="course-option" onclick="selectCourse('Bachelor of Science in Management Accounting', 'BSMA')">Bachelor of Science in Management Accounting</div>
                    <div class="course-option" onclick="selectCourse('Bachelor of Science in Business Administration', 'BSBA')">Bachelor of Science in Business Administration</div>
                    <div class="course-option" onclick="selectCourse('Bachelor of Science in Electronics Engineering', 'BSECE')">Bachelor of Science in Electronics Engineering</div>
                    <div class="course-option" onclick="selectCourse('Bachelor of Science in Industrial Engineering', 'BSIE')">Bachelor of Science in Industrial Engineering</div>
                    <div class="course-option" onclick="selectCourse('Bachelor of Science in Information Technology', 'BSIT')">Bachelor of Science in Information Technology</div>
                    <div class="course-option" onclick="selectCourse('Bachelor of Science in Psychology', 'BSP')">Bachelor of Science in Psychology</div>
                    <div class="course-option" onclick="selectCourse('Bachelor of Science in Education', 'BSED')">Bachelor of Science in Education</div>
                </div>

                <input type="hidden" id="course" name="course">
            </div>
        </div>

        <div class="field">
            <label>Student Photo</label>
            <div class="upload-area">
                <div class="upload-icon">↑</div>
                <p class="upload-title">Upload your photo</p>
                <p class="upload-sub">JPG or PNG • Max 5MB</p>
                <label for="studentPhoto" class="upload-btn">UPLOAD HERE</label>
                <input type="file" id="studentPhoto" name="studentPhoto" accept="image/png, image/jpeg" hidden>
                <p id="fileName" class="file-name"></p>
            </div>
        </div>

        <div class="button-row">
            <button type="button" class="cancel-btn" onclick="cancelRegistration()">CANCEL</button>
            <button type="submit" class="submit-btn">REGISTER</button>
        </div>

    </form>
</div>

<div id="successPopup" class="popup-overlay">
    <div class="success-popup">
        <div class="success-icon">✓</div>
        <h3>Registration Successful!</h3>
        <p>Student registration has been completed successfully.</p>
        <div class="progress-bar"><div class="progress"></div></div>
        <span>Returning to the main page...</span>
    </div>
</div>

<script>
const photoInput=document.getElementById("studentPhoto");
const fileName=document.getElementById("fileName");
const form=document.getElementById("studentRegistrationForm");
const dropdown=document.getElementById("courseDropdown");

photoInput.addEventListener("change",function(){
    fileName.textContent=this.files.length?this.files[0].name:"";
});

function toggleCourses(){
    dropdown.classList.toggle("open");
}

function selectCourse(name,value){
    const selected=document.getElementById("selectedCourse");
    selected.textContent=name;
    selected.style.color="var(--text)";
    document.getElementById("course").value=value;
    dropdown.classList.remove("open");
}

document.addEventListener("click",function(e){
    if(!dropdown.contains(e.target)){
        dropdown.classList.remove("open");
    }
});

form.addEventListener("submit",function(e){
    e.preventDefault();

    if(!document.getElementById("course").value){
        alert("Please select your course.");
        return;
    }

    document.getElementById("successPopup").classList.add("show");

    setTimeout(function(){
        window.location.href="{{ route('student.lookup') }}";
    },5000);
});

function cancelRegistration(){
    form.reset();
    fileName.textContent="";
    const selected=document.getElementById("selectedCourse");
    selected.textContent="Select your course";
    selected.style.color="var(--gray)";
    document.getElementById("course").value="";
    dropdown.classList.remove("open");
}

function exitRegistration(){
    window.history.back();
}
</script>

</body>
</html>