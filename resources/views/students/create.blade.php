<h1>Add Student</h1>

<form method="POST" action="/students">
    @csrf

    <label>Name</label>
    <input type="text" name="name"><br><br>

    <label>Student Number</label>
    <input type="text" name="student_number"><br><br>

    <label>Course</label>
    <input type="text" name="course"><br><br>

    <button type="submit">Save Student</button>
</form>