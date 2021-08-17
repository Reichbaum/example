'use strict';
const userLang = $('#langButton').data('language')

$(document).ready(function () {

	if (document.querySelector('.available-time')) {
		const ps = new PerfectScrollbar(document.querySelector('.available-time', {
			wheelPropagation: false
		}));
	}

	checkTimezone()
	initDatepicker()
	setTimezone(false)

	if (typeof (datesAndTime && datesAndTime['busy']) !== 'undefined') {
		setDisabledDates(datesAndTime['busy'])
	}

	$('input[name="cf_lang"]:checked').parent().addClass('active')

	const wpcf7Elm = document.querySelector('.wpcf7')

	if (wpcf7Elm != null) {
		wpcf7Elm.addEventListener('wpcf7mailsent', function (event) {
			$('#consulting_form_fields').hide()
		}, false)
	}

	// get_google_calendar_ajax();
})

function initDatepicker() {

	$.fn.datepicker.dates['ru'] = {
		days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
		daysShort: ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"],
		daysMin: ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"],
		months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
		monthsShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
		today: "Сегодня",
		clear: "Очистить",
		format: "dd.mm.yyyy",
		titleFormat: "MM yyyy",
		weekStart: 1
	}

	$('#calender').datepicker({
		daysOfWeekDisabled: ['00', '06'],
		daysOfWeekHighlighted: ['01', '02', '03', '04', '05'],
		startDate: '+1d',
		language: userLang === 'ru' ? 'ru' : 'en',
		weekStart: userLang === 'ru' ? 1 : 0,
		templates: {
			leftArrow: '<i class="fas fa-chevron-left"></i>',
			rightArrow: '<i class="fas fa-chevron-right"></i>'
		}
	}).change(dateChanged).on('changeDate', dateChanged)

}

function setDisabledDates(datesAndTime) {
	let disabledDates = []
	let formattedDate = ''
	let formDate = ''
	let date = ''
	$.each(datesAndTime, function (index, value) {
		if (value['time'].length == 7 || value['time'][0] == 'NA') {
			formattedDate = new Date(index);
			const ye = formattedDate.getUTCFullYear();
			let mo = +formattedDate.getUTCMonth() + 1;
			mo = setDateToDoubleNumber(mo);
			const da = formattedDate.getUTCDate();
			if (userLang === 'ru') {
				formDate = `${da}.${mo}.${ye}`
			} else if (userLang === 'en') {
				formDate = `${mo}/${da}/${ye}`
			}
			disabledDates.push(formDate)
		}
		$('#calender').datepicker('setDatesDisabled', disabledDates)
	})
}

function setDateToDoubleNumber(d) {
	return (d < 10) ? '0' + d.toString() : d.toString();
}

function checkTimezone() {
	const formattedTime = Intl.DateTimeFormat().resolvedOptions().timeZone
	const timezoneSelect = $('.time_zone_option')
	timezoneSelect.each(function () {
		if ($(this).val() === formattedTime) {
			$(this).attr('selected', true)
			$(this).addClass('current-timezone')
			return false
		}
	})
}

function setTimezone(show) {
	let timezoneValue
	const timezoneOffset = new Date().getTimezoneOffset() / 60 - 4
	let currentTimezone = $('.current-timezone')
	if (currentTimezone.length !== 0) {
		timezoneValue = currentTimezone.text()
		show ? $('#current_timezone').html(timezoneValue) : null
	}
	setTimeWithTimezone(timezoneOffset)
}

function setTimeWithTimezone(timezoneOffset) {
	$('.time-item').each(function () {
		let newTimeValue = parseFloat($(this).data('time') - parseInt(timezoneOffset)).toFixed(2).toString()
		$(this).text(newTimeValue)
	})
}

function dateChanged(ev) {
	let calender = $('#calender')
	let choosenDate = ''

	if (userLang === 'ru') {
		choosenDate = calender.datepicker('getFormattedDate', 'dd M yyyy')
	} else choosenDate = calender.datepicker('getFormattedDate', 'MM dd, yyyy')

	let formattedDate = calender.datepicker('getFormattedDate', 'yyyy-mm-dd')

	$('#date_consulting').html(choosenDate)
	$('#formatted_date').val(formattedDate)
	calender.hide('fast')

	let busyTimes = []
	let availableTimes = []

	$('#default_time').show()
	$('#consultation_time').hide()

	if (datesAndTime && datesAndTime['available']) {
		let timeItems = ''
		$.each(datesAndTime['available'], function (index, value) {
			if (value['date'] === formattedDate) {
				$('#default_time').hide()
				$('#consultation_time').show()
				availableTimes = value['time']
				$.each(availableTimes, function (index, value) {
					timeItems += `<p class="time-item" onclick="timeChanged(this)" data-time="${value}">${value}</p>`
				})
				$('#consultation_time').html(timeItems)
				setTimezone(false)
			}
		})

	}

	if (datesAndTime && datesAndTime['busy']) {
		$.each(datesAndTime['busy'], function (index, value) {
			if (index === formattedDate) {
				busyTimes = value['time']
			}
		})
	}

	$('#timeline').show('slow')
	$('.time-item').removeClass('non-available')

	const times = $('.time-item')

	if (busyTimes.length !== 0) {
		busyTimes.forEach(element => {

			times.filter(function (index) {
				if ($(this).data('time') === element) {
					return true
				}

			}).addClass('non-available')
		})
	}
}

function timeChanged(e) {
	$('.time-item').removeClass('active')
	$(e).addClass('active')
	let choosenTime = $(e).text()
	$('#time_consulting').html(choosenTime)
	$('#consulting_confirm').show('fast')
	setTimezone(true)
}

function timezoneChanged() {
	$('.time_zone_option').removeClass('current-timezone')
	let timezoneValue = $('#time_zone option:selected')
	let textTimezone = timezoneValue.text()
	let newTimeZoneOffset = -4

	if (timezoneValue.text().includes('+') || timezoneValue.text().includes('-')) {
		let slicedTimezone = timezoneValue.text().slice(4, 7)
		newTimeZoneOffset = -parseInt(slicedTimezone) - 4
	}
	$('#current_timezone').html(timezoneValue.text())
	$('#cf_timezone').val(timezoneValue.text())
	setTimeWithTimezone(newTimeZoneOffset)
	let newUserTime = $('.time-item.active').text()
	$('#time_consulting').html(newUserTime)
}

function goBackToCalender() {
	$('.time-item').removeClass('active')
	$('.time-item').removeClass('non-available')
	$('#time_consulting').html('')
	$('#timeline').hide('slow')
	$('#consulting_confirm').hide('fast')
	$('#calender').show('slow')
}

function goBackToTimeline() {
	$('#consulting_form_show').hide('fast')
	$('#timeline').show('slow')
	$('#consulting_confirm').show('slow')
	$('.submit-success').hide()
}

function confirmShowForm() {
	$('#consulting_form_fields').show();
	$('.wpcf7-response-output').hide();
	$('#timeline').hide('fast')
	$('input[name="cf_messenger"]').parent().hide()
	$('#consulting_confirm').hide('fast')
	$('#consulting_form_show').show('slow')
	$('#cf_date').val($('#formatted_date').val())
	$('#cf_userdate').val($('#date_consulting').text())
	$('#cf_time').val($('.time-item.active').data('time'))
	$('#cf_usertime').val($('#time_consulting').text())
	$('#cf_timezone').val($('#current_timezone').text())
}

function langChange() {
	$('input[name="cf_lang"]:not(:checked)').parent().removeClass('active')
	$('input[name="cf_lang"]:checked').parent().addClass('active')
}

function messengerChange() {
	$('input[name="cf_messenger_choose"]:not(:checked)').parent().removeClass('active')
	$('input[name="cf_messenger_choose"]:checked').parent().addClass('active')
	$('input[name="cf_messenger"]').parent().show()
}