@inject('carbon', 'Carbon\Carbon')
<x-layout>
	@slot ('title')
		Tracker
	@endslot
	
	<div class="container">
		<div class="d-flex flex-wrap">
			<div class="d-flex justify-content-center flex-fill">

				<button id="lastMonth" onclick="getLastMonth()" class="btn link-primary align-self-center"><h2><-</h2></button>
				<div class="text-center">
					<h4>{{ $tracker->title }}</h4>
			
					@if($nextProcess) 
						@if ($nextProcess->date == date('Y-m-d'))
							<a href="{{ route('process.update', ['id'=> $nextProcess->id]) }}" class="btn btn-promary">

								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check-lg" viewBox="0 0 16 16">
								  <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
								</svg>

								<span class="link-primary">Сделано</span>
							</a>
						@else
							<div class="my-3">Следуюший {{$carbon->createFromFormat('Y-m-d', $nextProcess->date)->format('d.m.Y')}}</div>
						@endif
					@else
						<div class="mt-3">Период трекера завершен</div>
					@endif

					<div><span class="fw-bold" id="year"></span> - <span class="fw-bold" id="month"></span></div>

					<table id="calendar">
						<tr></tr>
					</table>

					<a href="/tracker/delete/{{ $tracker->id }}" class="btn btn-danger">Удалить трекер</a>

				</div>
				<button id="nextMonth" onclick="getNextMonth()" class="btn link-primary pt-6 align-self-center"><h2>-></h2></button>
			</div>

			<div id="comments" class=" p-2 ">
				<form action="{{ route('comment.store', ['tracker_id' => $tracker->id]) }}" method="post">
					@csrf

					<div class="mb-3">
					  <label for="text" class="form-label">Мои комментарии</label>
					   <textarea class="form-control" name="text" rows="3"> @if (old('text')) {{ old('text') }} @endif </textarea>
					</div>

					<input type="submit" class="btn" value="Сохранить">
				</form>

				@foreach ($tracker->comments as $comment)
					<div>{{ $carbon->createFromFormat('Y-m-d H:m:s',$comment->created_at)->format('d.m.Y') }}</div>
					<div class="comment{{ $comment->id }}">{{ $comment->text }}</div>

					<a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn mb-3">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
						  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
						  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
						</svg>
					</a>

					<button type="button" class="btn mb-3 updateComment" data-bs-toggle="modal" data-bs-target="#exampleModal" id="comment{{ $comment->id }}" onclick="updateComment(this)">
					    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-pen-fill" viewBox="0 0 16 16">
						  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
					    </svg>
					</button>

					<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-body">
					        <form action="{{ route('comment.update', ['id' => $comment->id]) }}" method="post">
					        	@csrf
					            <div class="mb-3">
								  <label for="text" class="form-label">Мои комментарии</label>
								   <textarea class="form-control" name="text" rows="3" id="comment-update-text"></textarea>
								</div>

								<input type="submit" class="btn btn-success" value="Изменить">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
					          
					        </form>
					      </div>
					    </div>
					  </div>
					</div>
				@endforeach
			</div>
		</div>
	</div>

	<div style="display: none;">
		@foreach($processes as $process)
			<div class="processDate">{{ $process['date'] }}</div>
			<div class="result">{{ $process['done'] }}</div> <br>
		@endforeach
	</div>

	<script src="{{ asset('/js/calendarTracker.js') }}"></script>
</x-layout>