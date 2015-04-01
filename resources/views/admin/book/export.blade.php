<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<style>@page { margin: 0px; }</style>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<h1 class="text-center">KOLEKSI BUKU</h1>
	<hr>
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Kode</th>
				<th>Judul</th>
				<th>Pengarang</th>
				<th>Penerbit</th>
				<th>Edisi</th>
				<th>Jenis</th>
				<th>Subyek</th>
				<th>Rak</th>
				<th>Tanggal Masuk</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			@foreach($books as $book)
				<?php $authors = [] ?>
				@foreach($book->author as $author)
					<?php $authors[] = $author->nama ?>
				@endforeach
				<tr>
					<td>{{ $book->id }}</td>
					<td>{{ $book->judul }}</td>
					<td>{{ implode(', ',$authors) }}</td>
					<td>{{ $book->publisher->nama }}</td>
					<td>{{ $book->edisi }}</td>
					<td>{{ $book->jenis }}</td>
					<td>{{ $book->subject->nama }}</td>
					<td>{{ $book->rack->nama }}</td>
					<td>{{ $book->tanggal_masuk }}</td>
					<td>{{ $book->keterangan }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>
