jQuery(document).ready(function ($) {


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

	$('#multidatepicker').datepicker({
	format: 'yyyy-mm-dd',
	multidate: true,
	language: 'ru'
	});




})