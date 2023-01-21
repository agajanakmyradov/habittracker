

	function getMonth(time = null) {
		if (time == null) {
			let date = new Date();
			time = [date.getFullYear(), date.getMonth()]
		}

		let lastDay = getLastDateOfMonth(time);
		let sunday = getFirsWeekDay(time);
		let monday = 1;
		let firstWeek = true;
		let count = 1;
		let calendar = document.querySelector('#calendar').querySelector('tbody');
		let processObj = getProcessObj();

		calendar.innerHTML = '<tr>' +
								'<th class="p-2">Пн</th>' +
								'<th class="p-2">Вт</th>' +
								'<th class="p-2">Ср</th>' +
								'<th class="p-2">Чт</th>' +
								'<th class="p-2">Пт</th>' +
								'<th class="p-2">Сб</th>' +
								'<th class="p-2">Вс</th>' +
							'</tr>';

		while (count <= lastDay) {
			let week = document.createElement('tr');

			if (firstWeek) {
			    let emptyDays = 7 - sunday;
			    let days = '';

			    for (var i = 0; i < emptyDays; i++) {
			    	days = days + '<td></td>';
			    }

			    week.innerHTML = week.innerHTML + days;

			    firstWeek = false;
			}

			if (sunday < lastDay ) {
				for (var i = monday; i <= sunday; i++) {
					let num = addZero(String(i));
					let td = createTableColumn(time, num, processObj);
					week.innerHTML = week.innerHTML + td;
				}
			} else {
				for (var i = monday; i <= lastDay; i++) {
					let num = String(i);
					let td = createTableColumn(time, num, processObj);
					week.innerHTML = week.innerHTML + td;
				}
			}
            
            monday = sunday + 1;
			count = sunday;
			sunday = sunday + 7;
			calendar.innerHTML = calendar.innerHTML + week.innerHTML;

		}

		document.querySelector('#year').innerHTML = time[0];
		document.querySelector('#month').innerHTML = time[1] + 1;		
	}

	function getLastDateOfMonth(time = null) {
		let lastDate = 0;

		if (time == null) {
			let date = new Date();
			let year = date.getFullYear();
			let month = date.getMonth() + 1;

			if (month == 12) {
				month = 0;
				year = year + 1;
			}

			lastDate = new Date(year, month, 0);
		} else {
			let year = time[0];
			let month = time[1] + 1;

			if (month == 12) {
				month = 0;
				year = year + 1;
			}

			lastDate = new Date(year, month, 0);

		}

		return lastDate.getDate();
	}

	function getFirsWeekDay(time = null) {
		let weekDay = 0;

		if (time == null) {
			let date = new Date();
			let year = date.getFullYear();
			let month = date.getMonth();

			weekDay = new Date(year, month, 1);
		} else {
			weekDay = new Date(time[0], time[1], 1);			
		}

		let days = 7 - weekDay.getDay() + 1;

		if (days > 7) {
			days = 1;
		}

		return days;
	}

	
	 getMonth();

	 function getLastMonth() {
	 	let month = Number(document.querySelector('#month').innerHTML - 2);
	 	let year = Number(document.querySelector('#year').innerHTML);

	 	if (month < 0) {
	 		month = 11;
	 		year = year - 1;
	 	}
	 	
	 	getMonth([year, month]);
	 }

	 function getNextMonth() {
	 	let month = Number(document.querySelector('#month').innerHTML);
	 	let year = Number(document.querySelector('#year').innerHTML);

	 	if (month > 11) {
	 		month = 0;
	 		year = year +1;
	 	}
	 	
	 	getMonth([year, month]);
	 }

	 function addZero(num) {
		if(num.length < 2) {
		 	num = '0' + num;
		}

		return num;
	 }

	function getProcessObj() {
   		let processDate = document.querySelectorAll('.processDate');
	   	let result = document.querySelectorAll('.result');
	   	let processObj = {};

	   	for (var i = 0; i < processDate.length; i++) {
	   		processObj[processDate[i].innerHTML] = result[i].innerHTML;
	   	}

	   	return processObj;
   	}



   	function createTableColumn(time, num, processObj) {
   		let year = String(time[0]);
   		let month = addZero(String(time[1] + 1));
   		let key = year + '-' + month + '-' + num;
   		let date = new Date();
   		let today = date.getFullYear() + '-' + addZero(String(date.getMonth() + 1)) + '-' + addZero(String(date.getDate()));
   		let td = '';

   		if (key == today) {
   			if (key in processObj) {
	   			if (processObj[key] == 1) {
	   				td = '<td class="p-2 text-bg-success border border-info">' + num + '</td>'; 
	   			} else {
	   				 td = '<td class="p-2 text-bg-danger border border-info">' + num + '</td>';
	   			}
	   		} else {
	   			td = '<td class="p-2  border border-info">' + num + '</td>';
	   		}
   		} else {
   			if (key in processObj) {
	   			if (processObj[key] == 1) {
	   				td = '<td class="p-2 text-bg-success">' + num + '</td>'; 
	   			} else {
	   				 td = '<td class="p-2 text-bg-danger">' + num + '</td>';
	   			}
	   		} else {
	   			td = '<td class="p-2 ">' + num + '</td>';
	   		}
   		}

   		return td;
   	}

   	function updateComment(obj) {
   		let comment = document.querySelector('.' + obj.id);
   		let textarea = document.querySelector('#comment-update-text');
   		textarea.innerHTML = comment.innerHTML
   	}



