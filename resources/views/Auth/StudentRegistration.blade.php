<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php // Randell updated this portion | October 4, 2026 | 10:34 AM | Admin function: page title renamed @endphp
    @php // Original: <title>Student Registration</title> @endphp
    <title>Register Student | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style1.css') }}">
</head>
<body>

<div class="registration-card">
    @php // Randell updated this portion | October 4, 2026 | 11:00 AM | Admin interface: renamed exitRegistration to backToLookup @endphp
    @php // Original: <button type="button" class="close-btn" onclick="exitRegistration()">×</button> @endphp
    <button type="button" class="close-btn" onclick="backToLookup()">×</button>

    <div class="heading">
        @php // Randell updated this portion | October 4, 2026 | 10:34 AM | Admin function: the admin enters the student, so the heading is no longer worded as the student registering @endphp
        @php // Original: <h1>STUDENT REGISTRATION</h1> @endphp
        <h1>REGISTER STUDENT</h1>
        @php // Randell updated this portion | October 4, 2026 | 10:34 AM | Admin function: wording now speaks to the admin, not the student @endphp
        @php // Original: <p>Create your student account to get started.</p> @endphp
        <p>Enter the student's information to add them to the system.</p>
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
                    @php // Randell updated this portion | October 4, 2026 | 10:34 AM | Admin function: reworded for the admin @endphp
                    @php // Original: <span id="selectedCourse">Select your course</span> @endphp
                    <span id="selectedCourse">Select the student's course</span>
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

        @php // Randell updated this portion | October 4, 2026 | 11:00 AM | Added: Year Level and Section fields, the lookup page shows them @endphp
        <div class="field-row">
            <div class="field">
                <label for="yearLevel">Year Level</label>
                <input type="number" id="yearLevel" name="yearLevel" min="1" max="5" placeholder="Enter year level" required>
            </div>
            <div class="field">
                <label for="section">Section</label>
                <input type="text" id="section" name="section" maxlength="20" placeholder="Enter section" required>
            </div>
        </div>

        <div class="field">
            <label>Student Photo</label>
            <div class="upload-area">
                <div class="upload-icon">↑</div>
                @php // Randell updated this portion | October 4, 2026 | 10:34 AM | Admin function: reworded for the admin @endphp
                @php // Original: <p class="upload-title">Upload your photo</p> @endphp
                <p class="upload-title">Upload the student's photo</p>
                <p class="upload-sub">JPG or PNG • Max 5MB</p>
                <label for="studentPhoto" class="upload-btn">UPLOAD HERE</label>
                <input type="file" id="studentPhoto" name="studentPhoto" accept="image/png, image/jpeg" hidden>
                <p id="fileName" class="file-name"></p>
            </div>
        </div>

        <div class="button-row">
            @php // Randell updated this portion | October 4, 2026 | 11:00 AM | Admin interface: renamed cancelRegistration to clearStudentForm @endphp
            @php // Original: <button type="button" class="cancel-btn" onclick="cancelRegistration()">CANCEL</button> @endphp
            <button type="button" class="cancel-btn" onclick="clearStudentForm()">CANCEL</button>
            <button type="submit" class="submit-btn">REGISTER</button>
        </div>

    </form>
</div>

<div id="successPopup" class="popup-overlay">
    <div class="success-popup">
        <div class="success-icon">✓</div>
        @php // Randell updated this portion | October 4, 2026 | 10:34 AM | Admin function: popup title renamed @endphp
        @php // Original: <h3>Registration Successful!</h3> @endphp
        <h3>Student Registered!</h3>
        <p>Student registration has been completed successfully.</p>
        <div class="progress-bar"><div class="progress"></div></div>
        <span>Returning to the main page...</span>
    </div>
</div>

<script>
const photoInput=document.getElementById("studentPhoto");
const fileName=document.getElementById("fileName");
const form=document.getElementById("studentRegistrationForm");
// Randell updated this portion | October 4, 2026 | 11:00 AM | Added: where the form saves the student
const dropdown=document.getElementById("courseDropdown");
const REGISTER_URL=@json(route('admin.students.register'));

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

// Randell updated this portion | October 4, 2026 | 11:00 AM | Made async so it can wait for the database save
// Original: form.addEventListener("submit",function(e){
form.addEventListener("submit",async function(e){
    e.preventDefault();

    if(!document.getElementById("course").value){
        // Randell updated this portion | October 4, 2026 | 10:34 AM | Admin function: reworded for the admin
        // Original: alert("Please select your course.");
        alert("Please select the student's course.");
        return;
    }

    // Randell updated this portion | October 4, 2026 | 11:00 AM | Added: saves the student to the database first, the popup only shows if it worked
    const saveBtn=form.querySelector(".submit-btn");
    const data=new FormData();
    data.append("first_name",document.getElementById("firstName").value.trim());
    data.append("last_name",document.getElementById("lastName").value.trim());
    data.append("student_number",document.getElementById("studentNumber").value.trim());
    data.append("course",document.getElementById("course").value);
    data.append("year_level",document.getElementById("yearLevel").value);
    data.append("section",document.getElementById("section").value.trim());
    if(photoInput.files.length){
        data.append("photo",photoInput.files[0]);
    }

    saveBtn.disabled=true;

    try{
        const res=await fetch(REGISTER_URL,{
            method:"POST",
            headers:{"Accept":"application/json","X-CSRF-TOKEN":"{{ csrf_token() }}"},
            body:data
        });
        const result=await res.json().catch(function(){return {};});

        if(!res.ok){
            alert(result.errors?Object.values(result.errors)[0][0]:(result.message||"Something went wrong. Try again."));
            saveBtn.disabled=false;
            return;
        }
    }catch(err){
        alert("Could not reach the server. Try again.");
        saveBtn.disabled=false;
        return;
    }

    document.getElementById("successPopup").classList.add("show");

    setTimeout(function(){
        @php // Randell updated this portion | October 4, 2026 | 11:00 AM | Admin interface: route renamed from student.lookup to admin.lookup @endphp
        @php // Original: window.location.href="{{ route('student.lookup') }}"; @endphp
        window.location.href="{{ route('admin.lookup') }}";
    },5000);
});

// Randell updated this portion | October 4, 2026 | 11:00 AM | Admin interface: renamed cancelRegistration to clearStudentForm
// Original: function cancelRegistration(){
function clearStudentForm(){
    form.reset();
    fileName.textContent="";
    const selected=document.getElementById("selectedCourse");
    // Randell updated this portion | October 4, 2026 | 10:34 AM | Admin function: keep the reset text matching the dropdown label
    // Original: selected.textContent="Select your course";
    selected.textContent="Select the student's course";
    selected.style.color="var(--gray)";
    document.getElementById("course").value="";
    dropdown.classList.remove("open");
}

// Randell updated this portion | October 4, 2026 | 11:00 AM | Admin interface: renamed exitRegistration to backToLookup
// Original: function exitRegistration(){
function backToLookup(){
    window.history.back();
}
</script>

</body>
</html>