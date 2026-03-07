<h1>Add Author</h1>

<form method="POST" action="/authors">
@csrf

<label>Name</label>
<input type="text" name="name">

<button type="submit">Save Author</button>

</form>
