<x-layout>
	<div style="display: none;">
		@foreach($processes as $process)
			<div class="processDate">{{ $process['date'] }}</div>
			<div class="result">{{ $process['done'] }}</div> <br>
		@endforeach
	</div>

   <script>
	   	

	   	function getPrecossObj() {
	   		let processDate = document.querySelectorAll('.processDate');
		   	let result = document.querySelectorAll('.result');
		   	let processObj = {};

		   	for (var i = 0; i < processDate.length; i++) {
		   		processObj[processDate[i].innerHTML] = result[i].innerHTML;
		   	}

		   	return processObj
	   	}

	   	let processObj = getPrecossObj();

	   	if(processObj['2023-01-06'] == 0) {
	   		console.log('yes')
	   	} else {
	   		console.log('no')
	   	}



	  

	   	console.log(processObj['2023-01-06']);
   </script>
</x-layout>