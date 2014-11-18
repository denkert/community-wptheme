jQuery ($) ->
	class CategoriesView extends wp.media.View
		initialize: (params)=>
			super params
			@links = @$el.find('.ubergrid-tabs li a')
			@panels = @$el.find('.ubergrid-panels li')
			@links.on 'click', @onLinkClick
			@panels.eq(0).addClass('ubergrid-current')
			@links.eq(0).parent().addClass('ubergrid-current')

		onLinkClick: (event)=>
			event.preventDefault()
			@panels.removeClass('ubergrid-current')
			index = @links.index(event.target)
			@panels.eq(index).addClass('ubergrid-current')
			@links.parent().removeClass('ubergrid-current')
			$(event.target).parent().addClass('ubergrid-current')
	new CategoriesView(el: $('#grid_layout'))
	new CategoriesView(el: $('#grid_extras'))
	renameCellInputs = ->
		$("#cells .cell").each (index, cell) ->
			$(cell).find("*:input").each (inputIndex, input) ->
				name = $(input).attr("name")
				$(input).attr "name", name.replace(/^cells\[\d*\]/, "cells[" + index + "]")  if name

	class ImageSelector extends Backbone.View
		initialize: (options)=>
			super options
			@layoutSelector = options.layoutSelector
			@$selectImage = @$el.find('button.select-image')
			@$image = @$el.find('img')
			@$input = @$el.find('input')
			@$selectImage.click @selectImageClicked
			@$actionsWrapper = @$el.find '.actions-wrapper'
			@$deleteImage = @$el.find '.image-delete'
			@$overlay = @$el.find('.overlay')
			@$deleteImage.click @deleteImageClicked
			@$el.hover (=>
				if @$image.size() > 0
					@$actionsWrapper.fadeIn 'fast'
					@$overlay.fadeIn 'fast'
			), =>
				if @$image.size() > 0
					@$actionsWrapper.fadeOut 'fast'
					@$overlay.fadeOut 'fast'
			if @$image.size() == 0
				@$deleteImage.fadeOut 'fast'
			else
				@$actionsWrapper.fadeOut 'fast'
				@$overlay.fadeOut 'fast'

		selectImageClicked: (e)=>
			e.preventDefault()
			setImageField = (imageId) => @$input.val imageId
			loadNewImage = (selection) =>
				if @$image.size() == 0
					@$image = $("<img />").prependTo(@$el)
				@$image.attr "src", selection.attributes.url
				@$image.attr "class", "r1c1"
				@$deleteImage.fadeIn "fast"
				@$actionsWrapper.fadeOut 'fast'
				@$overlay.fadeOut 'fast'

				$.post 'admin-ajax.php',
					action: "uber_grid_generate_thumbnail"
					id: selection.id
					format: @layoutSelector.getCurrentLayout()
				, (response) => @$image.attr "src", response.url  if response.url
			flow = wp.media(
				title: "Select an image"
				library:
					type: "image"

				button:
					text: "Select Image"

				multiple: false
			).open()
			id = @$input.val()
			if id and id != ''
				flow.state().get('selection').reset( [wp.media.model.Attachment.get( id )])
			flow.state().set "display", false
			flow.state().on "select", (el) ->
				selection = @get("selection").single()
				setImageField selection.id
				loadNewImage selection
		deleteImageClicked: (event)=>
			event.preventDefault()
			@$image.remove()
			@$image = @$el.find 'img'
			@$input.val ''
			@$overlay.fadeOut 'fast'
			@$actionsWrapper.fadeIn 'fast'
			@$deleteImage.fadeOut 'fast'
			false


	class LayoutSelector extends Backbone.View
		initialize: =>
			super
			@$options = @$el.find '.layouts li'
			@layouts =
				"r1c1-io": "r1c1"
				"r1c2-ir": "r1c1"
				"r1c2-il": "r1c1"
				"r2c1-it": "r1c1"
				"r2c1-ib": "r1c1"
				"r2c2-io": "r2c2"
				"r2c2-it": "r1c2"
				"r2c2-ib": "r1c2"
				"r2c2-il": "r2c1"
				"r2c2-ir": "r2c1"
				"r1c2-io": "r1c2"
				"r2c1-io": "r2c1"
			@$options.removeClass "selected"
			@$el.find(".layouts li." + @$el.find("input").val()).addClass "selected"  if @$el.find("input").val()
			@$options.click @onLayoutChanged

		onLayoutChanged: (event)=>
			clicked = $(event.target).parent()
			@$el.find('.layouts li').removeClass "selected"
			clicked.addClass "selected"
			@$el.find("input").val clicked.attr("class").split(/\s+/)[0]
			@$el.removeClass @currentClass
			@$el.addClass @currentClass = @getImageSize()
			@trigger 'change'
		getImageSize: => @layouts[@$el.find("input").val()]

	class TemplateLayoutSelector extends LayoutSelector
		initialize: (options)=>
			super options
			if options.first
				@$el.find('h3 a').remove()
			else
				@$el.find('h3 a').click @onDeleteClicked

		onDeleteClicked: (event)=>
			event.preventDefault()
			@$el.remove()
			@trigger 'deleted'
	class CellEditorBase extends Backbone.View
		initialize: (opt)=>
			super opt
			@imageSelectors = []
			@colorPickersInitialized = false
			@initPickers() if opt.pickerOnCreate
			@$el.find(".image-selector").each (index, el) => new ImageSelector(el: el, layoutSelector: @layoutSelector)
			@$el.find("label.huge :checkbox").each((index, el) ->
				$(el).parent().parent().find(".column-1, .columns-2").hide()  unless $(el).is(":checked")
			).click ->
				$(this).parent().parent().find(".column-1, .columns-2").toggle()
			@$el.find('.select-link-mode').change @linkModeChanged
			@linkModeChanged()
			@$el.find(".section.expandable label.huge").on "click", (event) ->
				$(this).parent().find(".columns-2, .column-1").toggle()
				$(this).parent().toggleClass "expanded"



		toggle: (callback) =>
			@$el.find("> .cell-content").toggle callback
			@$el.toggleClass "expanded"

		reloadImages: =>
			ids = []
			inputs = view.find(".image-selector input")
			inputs.each (index, el) -> ids.push $(el).val()  if $(el).val()
			$.post "admin-ajax.php?action=uber_grid_reload_images",{
				ids: ids.join(",")
				layout: @layoutSelector.getCurrentLayout()
			}, (response) ->
				inputs.each (index, el) ->
					$(el).parent().find("img").attr "src", response.srcs[index]


		initPickers: =>
			unless @colorPickersInitialized
				@$el.find(".color-picker").wpColorPicker()
				@colorPickersInitialized = true
		linkModeChanged: =>
			mode = @$el.find(".select-link-mode").val()
			@$el.find(".select-link-mode").parent().parent().parent().find(".link-to-url, .link-to-lightbox").hide()
			@$el.find(".select-link-mode").parent().parent().parent().find(".link-to-" + mode).show()

	class Cell extends CellEditorBase
		initialize: (options)=>
			super options
			@$headerText = @$el.find('h3 .heading')
			@$layout = @$el.find '.layouts'
			@layoutSelector = new LayoutSelector(el: @$el.find('.cell-layout'))
			@$el.addClass @layoutSelector.getImageSize()
			@$el.find(".cell-title input.cell-title-editor").keyup @onTitleKeyUp
			@$el.find("h3").on "click", =>
				@initPickers() unless @colorPickersInitialized
				@toggle()
			@$el.find(".cell-delete").click (event)=>
				event.preventDefault()
				if confirm("Are you sure you want to delete it?")
					@$el.fadeOut "fast", ->
						$(this).remove()
						renameCellInputs()
			@$el.find(".cell-cancel").click (event)=>
				event.preventDefault()
				@$el.find("> .cell-content").toggle()
				$(event.target).closest("li").toggleClass "expanded"
			@$el.find(".cell-clone").click (event)=>
				event.preventDefault()
				clone = @$el.clone()
				# Reset selected values
				clone.removeClass("expanded").find(".cell-content").hide()
				clone.find(".color-picker").show().removeClass "wp-color-picker"
				clone.find(".wp-picker-container a, .wp-picker-container input[type=button], .wp-picker-holder").remove()
				clone.find(".wp-picker-container input[type=text]").unwrap().unwrap()
				@$el.parent().append clone
				clone.find("select, textarea").each (index, element) =>
					$(element).val $(@$el.find("select, textarea")[index]).val()
				renameCellInputs()
				new Cell(el: clone)
				false


		onTitleKeyUp: (event)=>
			text = $(event.target).val()
			if text
				@$headerText.text text
			else
				i = -1
				$("#cells > li").each (index, element) ->
					i = index  if element is $(this).closest("li")[0]
				@$headerText.html "Cell #{i}"
	class CellTemplate extends CellEditorBase
		initialize: (options)=>
			super options
			@$layouts = @$el.find('.layout-list')
			@initPickers()
			i = 0
			@layoutTemplate = @$layouts.find('li:first-child')[0].outerHTML
			for layout in @$el.find('.layout-list > li')
				layout = $(layout)
				new TemplateLayoutSelector(el: layout, first: i++ == 0 )
			@$el.find('a.add-layout').click @onAddLayoutClicked
		onAddLayoutClicked: (event)=>
			event.preventDefault()
			@$layouts.append(layout = $(@layoutTemplate))
			layout.find('h3 span').text(layout.find('h3 span').text().replace(/\d+/, @$layouts.find('>li').size().toString()))
			new TemplateLayoutSelector(el: layout, first: false)

	class ManualEditor extends Backbone.View
		initialize: (args)=>
			super args
			@wasVisible = false
			@$cells = @$el.find '#cells'
			$("#add-new-cell").click @onAddCellClick
			renameCellInputs()


		onAddCellClick: (event)=>
			event.preventDefault()
			@$cells.append cell = $("#cell-template .cell").clone()
			cell.find(".cell-title input.cell-title-editor").val "Cell " + (@$cells.find('.cell').size())
			cell.find(">h3 .heading").text cell.find(".cell-title input.cell-title-editor").val()
			(new Cell(el: cell, pickerOnCreate: true)).toggle ->
				if $(".cell").size() > 2
					$(document).scrollTo cell,
						offset: -100
						duration: 400
			renameCellInputs()

		show: =>
			@$el.addClass "active"
			unless @wasVisible
				@$cells.find(".cell").each (index, item) -> new Cell(el: item)
				@$cells.sortable update: renameCellInputs
			@wasVisible = true
		hide: => @$el.removeClass "active"
		append: (cells) =>
			@$cells.append cells
			renameCellInputs()
			cells.each (index, cell) -> new Cell(el: $(cell))

	class AutoEditor extends Backbone.View
		initialize: =>
			@$taxFilters = @$("#taxonomy-filters")
			@$customFilters = @$("#custom-field-filters")
			@$taxFilters.find("button").click ->
				$(this).closest("li").remove()
				false
			@$customFilters.find("button").click (event)->
				event.preventDefault()
				$(this).closest("li").remove()
			@$el.find('ul.filters li .button').click (event)->
				event.preventDefault()
				$(this).closest('li').remove()
			$("#add-taxonomy-filter").click (event)=>
				event.preventDefault()
				$("#taxonomy-filter-template li").clone().appendTo(@$taxFilters.find("ul")).find("button").click (event)->
					event.preventDefault()
					$(this).closest("li").remove()
				false

			$("#add-custom-field-filter").click (event)=>
				event.preventDefault()
				$("#custom-field-filter-template li").clone().appendTo(@$customFilters.find("ul")).find("button").click (event)->
					event.preventDefault()
					$(this).closest("li").remove()
			$("#build-now").click @onBuildNowClicked
			new CellTemplate(el: $("#auto-cell-template"))


		onBuildNowClicked: (event)=>
			event.preventDefault()
			spinner = $(this).parent().find(".spinner")
			spinner.css "display", "inline-block"
			$.post "admin-ajax.php?action=uber_grid_build_cells",
				data: $("#post").serialize()
			, (response) ->
				spinner.css "display", "none"
				response = $(response)
				existingCellsCount = $('#cells li.cell').size()
				$("#cells").append response
				for cellIndex in [(existingCellsCount)..(existingCellsCount + response.length)]
					el = $($('#cells li.cell')[cellIndex - 1])
					new Cell(el: el, pickers_on_create: false)
				renameCellInputs()
				$("#enable-manual-mode").click()

		show: => $("#auto-mode").addClass "active"

		hide: => $("#auto-mode").removeClass "active"



	manualEditor = undefined
	autoEditor = undefined
	$("#post").submit (event) ->
		$(this).parent().find(".spinner").show()
		$("#uber-grid-hack").val $("#post").serialize()

	$("#preview").click ->
		showPreviewWindow = ->
			$("#preview-backdrop, #preview-window").show().show()
			$("#preview-content").html ""
			$.post "admin-ajax.php?action=uber_grid_preview",
				data: $("#post").serialize()
			, (response) ->
				$("#preview-content").css "visibility", "hidden"
				$("#preview-content").html $(response)
				$("#preview-content").css "visibility", "visible"
				setTimeout (->
					$("#preview-content .uber-grid").packery "layout"
				), 200

			$("#preview-close, #preview-footer-close").click ->
				$("#preview-backdrop, #preview-window").hide()

		showPreviewWindow()

	$.post "admin-ajax.php?action=uber_grid_get_fonts", (response) ->
		updateStylesAvailable = (element) ->
			font = $(element).prev().val()
			element.find("option").remove()
			variantFound = false
			$.each response.items, (index, item) ->
				if item.family is font
					$.each item.variants, (index, variant) ->
						element.append $("<option />").text(variant)

					variantFound = true

			unless variantFound
				element.append $("<option value='light'>Light</option>")
				element.append $("<option value='regular' selected='selected'>Regular</option>")
				element.append $("<option value='bold'>Bold</option>")
		if response.error
			$("#grid_fonts #fonts").remove()
			$("#grid_fonts .spin-wrapper").remove()
			$("#grid_fonts .inside").append "<div class=\"error\">Error loading fonts</div>"
			return
		$("#fonts-loaded").val 1
		$.each response.items, (index, item) ->
			option = $("<option/>").text(item.family)
			$("#grid_fonts select[role=font]").append option

		$("#grid_fonts select[role=font]").each (index, element) ->
			$(element).find("option").each (index, option) ->
				$(option).attr "selected", "selected"  if $(option).attr('value') == $(element).attr("data-font")


		$("#grid_fonts select[role=style]").each (index, element) ->
			updateStylesAvailable $(element)
			$(element).find("option").each (index, option) ->
				$(option).attr "selected", "selected"  if $(option).attr('value') is $(element).attr("data-font")


		$("#grid_fonts select[role=font]").change ->
			updateStylesAvailable $(this).next()

		$("#grid_fonts .spin-wrapper").animate
			opacity: 0
		, ->
			$(this).remove()
			$("#grid_fonts #fonts").animate opacity: 1


	manualEditor = new ManualEditor(el: $('#manual-mode'))
	autoEditor = new AutoEditor(el: $('#auto-mode'))
	if $("#current-mode").val() is "auto"
		autoEditor.show()
	else
		manualEditor.show()
	$("#enable-manual-mode").click ->
		$("#enable-auto-mode").removeClass "nav-tab-active"
		$(this).addClass "nav-tab-active"
		$("#current-mode").val "manual"
		manualEditor.show()
		autoEditor.hide()
	$("#enable-auto-mode").click ->

		$("#enable-manual-mode").removeClass "nav-tab-active"
		$("#manual-mode").removeClass "active"
		$(this).addClass "nav-tab-active"
		$("#auto-mode").addClass "active"
		$("#current-mode").val "auto"
		manualEditor.hide()
		autoEditor.show()


	$("#publish").removeAttr "disabled"
