<h1>Authors</h1>

<a href="/authors/create">Add Author</a>

<table border="1">
<tr>
<th>ID</th>
<th>Name</th>
</tr>

@foreach($authors as $author)
<tr>
<td>{{ $author->id }}</td>
<td>{{ $author->name }}</td>
</tr>
@endforeach

</table>