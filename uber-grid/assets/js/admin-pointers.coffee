jQuery ($) ->
	$.each uber_grid_pointers[0], (index, element) ->
		options =
			content: "<h3>" + element.title + "</h3>" + element.content
			position: element.position
			close: (what) ->
				$.post "admin-ajax.php?action=uber_grid_dismiss_pointer",
					pointer: index

				return

		$(index).pointer(options).pointer "open"
		return

	return
