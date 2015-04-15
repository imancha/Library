@extends('app')

@section('title')
	Buku {{ ucfirst($jenis) }}
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if(count($books) > 0)
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Kode</th>
								<th>Judul Buku</th>
							</tr>
						</thead>
						<tbody>
						@foreach($books as $book)
							<tr>
								<td>
									@if(empty($book->file->filename))
										{{ $book->id }}
									@else
										<a href="#">{{ $book->id }}</a>
									@endif
								</td>
								<td>{{ $book->judul }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
				<span class="pull-left">
					<small class="c-gray">
						Showing {!! count($books) > 0 ? $books->perPage()*$books->currentPage()-$books->perPage()+1 : 0 !!}
						to {!! $books->perPage()*$books->currentPage() < $books->total() ? $books->perPage()*$books->currentPage() : $books->total() !!}
						of {!! $books->total() !!} entries
					</small>
				</span>
				<span class="pull-right">{!! $books->render() !!}</span>
			@else
				<div class="alert alert-warning" role="alert">
						<i class='fa fa-exclamation-circle' style='padding-right:6px'></i>
						<span class="sr-only">Error:</span>
						Data tidak ditemukan.
					</div>
			@endif
		</div>
	</div>
@endsection
