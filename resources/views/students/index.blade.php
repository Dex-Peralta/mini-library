<h1>Students</h1>

<a href="/students/create">Add Student</a>

<table border="1">
<tr>
<th>ID</th>
<th>Name</th>
<th>Student Number</th>
<th>Course</th>
<th>Actions</th>
</tr>

@foreach($students as $student)
<tr>
<td>{{ $student->id }}</td>
<td>{{ $student->name }}</td>
<td>{{ $student->student_number }}</td>
<td>{{ $student->course }}</td>

<td>
<a href="/students/{{ $student->id }}/edit">Edit</a>

<form action="/students/{{ $student->id }}" method="POST" style="display:inline;">
@csrf
@method('DELETE')
<button type="submit">Delete</button>
</form>
</td>

</tr>
@endforeach
</table>