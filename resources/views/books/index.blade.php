<h1>Books</h1>

<a href="/books/create">Add Book</a>

<table border="1">
<tr>
<th>ID</th>
<th>Title</th>
<th>Inventory</th>
<th>Authors</th>
</tr>

@foreach($books as $book)
<tr>
<td>{{ $book->id }}</td>
<td>{{ $book->title }}</td>
<td>{{ $book->inventory_count }}</td>

<td>
@foreach($book->authors as $author)
{{ $author->name }},
@endforeach
</td>

</tr>
@endforeach

</table>