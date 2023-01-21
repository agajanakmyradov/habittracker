<x-layout>
	@slot ('title')
		Tracker
	@endslot

	<div class="container">

		<form action="{{ route('tracker.store') }}" method="POST">
			@csrf
			<div class="mb-3">
			  <label for="title" class="form-label">Название</label>
			  <div style="color: red">@error('title') {{ $message }} @enderror</div>
			  <input type="text" class="form-control" name="title" @if (old('title')) value="{{ old('title') }}" @endif>
			</div>

			<div class="mb-3">
			 	<label for="period_type" class="form-label">Периодичность</label>
				<select class="form-select" name="period_type" id="type" onchange="showPeriodType()">
				  <option value="everyday" >Каждый день</option>
				  <option value="days" @if(old('period_type') == 'days') selected @endif>Через каждый N дней</option>
				  <option value="weekdays"  @if(old('period_type') == 'weekdays') selected @endif>По определенным дням недели</option>
				</select>
			</div>

			<div id="weekdays" class="mb-3">
				<div style="color: red">@error('weekday') {{ $message }} @enderror</div>
				<input class="form-check-input" type="checkbox" name="weekday[1]" value="1" @if (old('weekday.1')) checked @endif>
				<label class="form-check-label" for="flexCheckDefault">
				    Понидельник
				</label> <br>

				<input class="form-check-input" type="checkbox" name="weekday[2]" value="2"  @if (old('weekday.2')) checked @endif>
				<label class="form-check-label" for="flexCheckDefault">
				    Вторник
				</label> <br>

				<input class="form-check-input" type="checkbox" name="weekday[3]" value="3"  @if (old('weekday.3')) checked @endif>
				<label class="form-check-label" for="flexCheckDefault">
				    Среда
				</label> <br>

				<input class="form-check-input" type="checkbox" name="weekday[4]" value="4"  @if (old('weekday.4')) checked @endif>
				<label class="form-check-label" for="flexCheckDefault">
				    Четверг
				</label> <br>

				<input class="form-check-input" type="checkbox" name="weekday[5]" value="5"  @if (old('weekday.5')) checked @endif>
				<label class="form-check-label" for="flexCheckDefault">
				    Пятница
				</label> <br>

				<input class="form-check-input" type="checkbox" name="weekday[6]" value="6"  @if (old('weekday.6')) checked @endif>
				<label class="form-check-label" for="flexCheckDefault">
				    Суббота
				</label> <br>

				<input class="form-check-input" type="checkbox" name="weekday[0]" value="0"  @if (old('weekday.0')) checked @endif>
				<label class="form-check-label" for="flexCheckDefault">
				    Воскресение
				</label> <br>
			</div>

			<div class="mb-3 " id="days" >
				<div style="color: red">@error('days') {{ $message }} @enderror</div>
			    <div class="row g-3">
			    	<div class="col-auto">
					    Через
					 </div>
					 <div class="col-auto">
					    <input type="text" class="form-control" name="days">
					 </div>
					 <div class="col-auto">
					    дн.
					 </div>
			    </div>
			</div>

			<div id="everyday">
				
			</div>

			<div class="row form-group mb-3">
                <label for="last_day" class="col-form-label">Дата окончание</label>
                <div style="color: red">@error('last_day') {{ $message }} @enderror</div>
                <div class="col-sm-4">
                    <div class="input-group date" id="datepicker">
                        <input type="text" name="last_day" class="form-control">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white d-block">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>

			<input type="submit" class="btn btn-success" value="Сохранить">
		</form>
	</div>

	<script>
		function showPeriodType() {
			let arr = ['weekdays', 'days'];
			let type = document.querySelector('#type').value;

			for (i = 0; i < arr.length; i++) {
				if (type == arr[i]) {
					document.querySelector('#' + arr[i]).style.display = 'block';
				} else {
					document.querySelector('#' + arr[i]).style.display = 'none';
				}      
		    }
		    console.log(arr[0])


		}

		window.onload =  showPeriodType();

		$(function() {
            $('#datepicker').datepicker();
        });

	</script>
</x-layout>