<h1>Add Book</h1>

<form method="POST" action="/books">
@csrf

<label>Title</label>
<input type="text" name="title"><br><br>

<label>Inventory</label>
<input type="number" name="inventory_count"><br><br>

<label>Authors</label>
<select name="authors[]" multiple>

@foreach($authors as $author)
<option value="{{ $author->id }}">{{ $author->name }}</option>
@endforeach

</select>

<br><br>

<button type="submit">Save Book</button>

</form>