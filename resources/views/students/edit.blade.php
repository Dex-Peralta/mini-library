<h1>Edit Student</h1>

<form method="POST" action="/students/{{ $student->id }}">
@csrf
@method('PUT')

<input type="text" name="name" value="{{ $student->name }}">
<input type="text" name="student_number" value="{{ $student->student_number }}">
<input type="text" name="course" value="{{ $student->course }}">

<button type="submit">Update</button>

</form>