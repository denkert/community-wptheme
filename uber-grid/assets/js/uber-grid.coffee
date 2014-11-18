((jQuery) ->
	unless jQuery
		alert "Message from UberGrid: jQuery not found!"
	else if parseInt(jQuery().jquery.replace(/\./g, "")) < 172
		alert "Message from UberGrid You have jQuery < 1.7.2. Please upgrade your jQuery or enable \"Force new jQuery version\" option at UberGrid settings page."
	else
		unless Packery
			alert "Message from UberGrid: Packery library is not loaded. Please contact UberGrid developer for help."
		else
			$ = jQuery
			# ========================= smartresize ===============================

			#
			#   * smartresize: debounced resize event for jQuery
			#   *
			#   * latest version and complete README available on Github:
			#   * https://github.com/louisremi/jquery.smartresize.js
			#   *
			#   * Copyright 2011 @louis_remi
			#   * Licensed under the MIT license.
			#
			$event = $.event
			dispatchMethod = (if $.event.handle then "handle" else "dispatch")
			resizeTimeout = undefined
			$event.special.smartresize =
				setup: ->
					$(this).bind "resize", $event.special.smartresize.handler
					return

				teardown: ->
					$(this).unbind "resize", $event.special.smartresize.handler
					return

				handler: (event, execAsap) ->

					# Save the context
					context = this
					args = arguments

					# set correct event type
					event.type = "smartresize"
					clearTimeout resizeTimeout  if resizeTimeout
					resizeTimeout = setTimeout(->
						$event[dispatchMethod].apply context, args
						return
					, (if execAsap is "execAsap" then 0 else 100))
					return

			$.fn.smartresize = (fn) ->
				(if fn then @bind("smartresize", fn) else @trigger("smartresize", ["execAsap"]))
			is_touch_device = ->
				ua = navigator.userAgent
				!!('createTouch' in document || screen.width <= 699 ||
				ua.match(/(iPhone|iPod|iPad)/) || ua.match(/BlackBerry/) || ua.match(/Android/))

			class LightboxAdapter
				constructor: (grid, $el)->
					@grid = grid
					@$el = $el
					@reset()
					@checkForDeeplink()
				checkForDeeplink: =>
					if location.hash.match(/^#\d+\-/)
						gridId = location.hash.replace(/^#/, '').replace(/[^\d]+.*$/, '')
						return if (gridId != @getId())
						page = parseInt(location.hash.replace(/\/[^\/]+$/, '').replace(/[^\/]+\//, ''))
						image = location.hash.replace(/^.*\//, '')
						@loadDeepLink(page, image)
				loadDeepLink: (page, image)=>
					if @grid.pagination
						if @grid.pagination.pages[page]
							@grid.pagination.showPage(page)
							@clickImage(image)
						else
							@grid.pagination.loadPage page, => @clickImage(image)
					else
						@clickImage(image)
				clickImage: (image)=>
					for cell in @getLightboxLinks().closest('.uber-grid-cell')
						if jQuery(cell).attr('data-slug') == image
							jQuery(cell).find('a.uber-grid-lightbox').click()



				addImages: (images)=>
				reset: =>
					(@getLightboxLinks().on 'click:ubergrid', @onImageClicked)
				imageSelector: '.uber-grid-cell:has(a.uber-grid-cell-wrapper.uber-grid-lightbox):not(.uber-grid-blurred), .uber-grid-cell:has(a.uber-grid-hover.uber-grid-lightbox):not(.uber-grid-blurred)'
				linkSelector: '.uber-grid-cell:not(.uber-grid-blurred) a.uber-grid-cell-wrapper.uber-grid-lightbox, .uber-grid-cell:not(.uber-grid-blurred) a.uber-grid-hover.uber-grid-lightbox'
				getLightboxImages: => @$el.find(@imageSelector)
				getLightboxLinks: => @$el.find(@linkSelector)
				onImageClicked: (event)=>
					cell = jQuery(event.target).closest('.uber-grid-cell')
					@scrollTop = jQuery(document).scrollTop()
					@setHash(cell)
				getLightboxImageUrl: (el)=> jQuery(el).find('a.uber-grid-cell-wrapper, a.uber-grid-hover').attr('href')
				getLightboxImageThumbnailUrl: (el)=>jQuery(el).find('img.uber-grid-cell-image').attr('src')
				getLightboxImageCaption: (el)=>jQuery(el).find('.uber-grid-lightbox-content div').html()
				getLightboxImageTitle: (el)=>jQuery(el).find('.uber-grid-lightbox-content h3').html()
				getLightboxImageWidth: (el)=>jQuery(el).find('img.uber-grid-image').data('lightbox-width')
				getLightboxImageHeight: (el)=>jQuery(el).find('img.uber-grid-image').data('lightbox-width')
				getId: => @$el.attr('id').replace('uber-grid-', '')
				getSlug: => @$el.closest('.uber-grid-wrapper').attr('data-slug')
				setHash: (cell)=>
					slug = cell.attr('data-slug')
					page = if @grid.pagination then @grid.pagination.currentPage else 1
					id = @getId()
					location.hash = "#{id}-#{@getSlug()}/#{page}/#{slug}"
				resetHash: ->
					if @prevHash
						location.hash = @prevHash
						delete @prevHash
					else
						location.hash = '#'
					jQuery(document).scrollTop(@scrollTop) if @scrollTop and @scrollTop > 0
				onDeeplinkOpened: =>
				onKeyUp: (event)=>
					if event.keyCode == 37
						@onPrevSlide()
					else if event.keyCode == 39
						@onNextSlide()
					else if event.keyCode == 27
						@onAfterClose()
				onAfterClose: =>
					jQuery(window).off 'keyup', @onKeyup
					@resetHash()
				onNextSlide: =>
					@currentIndex += 1
					lightboxLinks = @getLightboxLinks()
					if @currentIndex == lightboxLinks.length
						@currentIndex = lightboxLinks.length - 1
					@setHash(@getLightboxLinks().eq(@currentIndex).closest('.uber-grid-cell'))
				onPrevSlide: =>
					@currentIndex -= 1
					if @currentIndex < 0
						@currentIndex = 0
					@setHash(@getLightboxLinks().eq(@currentIndex).closest('.uber-grid-cell'))

			class FooBoxAdapter extends LightboxAdapter
				constructor: (grid, $el)->
					if (!$el.foobox)
						alert("Foobox is not detected!")
						return
					super grid, $el
					@reset()
				reset: =>
					super()
					for image in images = @getLightboxImages()
						image = jQuery(image)
						image.find('.uber-grid-hover').data(
							width: @getLightboxImageWidth(image)
							height: @getLightboxImageHeight(image)
						)
						image.attr('title', @getLightboxImageCaption(image))
						image.find('img').attr('alt', @getLightboxImageTitle(image))
					fooboxOptions = {selector: @imageSelector}
					if window.FOOBOX.o
						fooboxOptions = jQuery.extend window.FOOBOX.o,{deeplinking: false, affiliate: false, slideshow: {enabled: true}, selector: @linkSelector}
					@$el.foobox(fooboxOptions).on('foobox.afterLoad', (event)=>
						@setHash(images.eq(event.fb.item.index).closest('.uber-grid-cell'))
					).on('foobox.close', => @resetHash())
			class MagnificPopupAdapter extends LightboxAdapter
				constructor: (grid, $el)->
					super grid, $el
				onImageClicked: (event)=>
					_this = this
					if jQuery(event.target).closest('.uber-grid-cell').is('.uber-grid-blurred')
						event.preventDefault();
						event.stopPropagation();
						return false
					super event
					event.preventDefault()
					masterPopupSettings = {
						gallery: {enabled: true, navigateByImgClick: true, preload: [1,1]},
						closeBtnInside: true,
						mainClass: 'mfp-fade',
						closeMarkup: '<button title="%title%" type="button" class="mfp-close"></button>'
					}
					items = @getLightboxLinks()
					index = items.index(jQuery(event.target).closest('a.uber-grid-lightbox'))

					settings = jQuery.extend(masterPopupSettings,{
						items: jQuery.map items,(item)->
							isImage = -> item.attr('href').match(/(\.jpe?g|\.png|\.gif)$/i);
							isInline = -> return item.attr('href').match(/^#/);
							item = jQuery(item)
							settings = {src: item.attr('href')};
							if isInline()
								settings.type = 'inline';
								if (settings.src == '#')
									settings.src = jQuery(item.closest('div.uber-grid-cell').find('.uber-grid-lightbox-content-wrapper').html())
							else if isImage()
								settings.type = 'image'
							else
								settings.type = 'iframe'
							settings.ubergridCell = item.closest('div.uber-grid-cell')
							settings
						image: {
							titleSrc: ->
								if (this.currItem.data.ubergridCell.find('.uber-grid-lightbox-content-wrapper').size())
									return this.currItem.data.ubergridCell.find('.uber-grid-lightbox-content-wrapper').html()
								return ''

							markup: '<div class="mfp-figure">'+
							'<div class="mfp-close"></div>'+
							'<figure>'+
							'<div class="mfp-img"></div>'+
							'<div class="mfp-uber-grid-border"></div>' +
							'<figcaption>'+
							'<div class="mfp-bottom-bar">' +
							'<div class="mfp-title"></div>'+
							'<div class="mfp-counter"></div>'+
							'</div>'+
							'</figcaption>'+
							'</figure>'+
							'</div>',

						},
						callbacks: {
							open: (-> jQuery('.mfp-wrap').addClass('mfp-uber-grid')),
							markupParse: ((template)-> template.find('.mfp-counter').remove()),
							afterClose: => @resetHash()
							afterChange: ->
								if !is_touch_device()
									jQuery('.mfp-bottom-bar').addClass('uber-grid-visible').height()
									setTimeout (-> jQuery('.mfp-bottom-bar').removeClass('uber-grid-visible')), 1500
								_this.setHash this.currItem.data.ubergridCell
						}

					})
					jQuery.magnificPopup.open settings, index
					jQuery('.mfp-bottom-bar').addClass('uber-grid-visible').height()




			class JetpackAdapter extends LightboxAdapter
				constructor: (grid, $el)->
					super grid, $el
					@$el.data('carousel-extra', {blog_id: 1, permalink: 'http://awesome-gallery.dev'})
				reset: =>
					super
					for image in @getLightboxImages().addClass('tiled-gallery-item')
						image = jQuery(image)
						img = image.find('img.uber-grid-cell-image')
						link = image.closest('.uber-grid-cell').find('a.uber-grid-hover, a.uber-grid-cell-content, a.uber-grid-lightbox')
						image_id = link.data('lightbox-image-id')
						img.data({
							'orig-file': link.attr('href'),
							'orig-size': img.data('lightbox-width') + "," + img.data('lightbox-height'),
							'large-file': link.attr('href'),
							'medium-file': link.attr('href'),
							'small-file': link.attr('href'),
							'image-title': image.find('.uber-grid-lightbox-content h3').html(),
							'image-description': image.find('.uber-grid-lightbox-content div').html(),
							'image-meta': {},
							'attachment-id': if image_id then image_id else 'asg-hack', # A hack to show the gallery
							'comments-opened': if image_id then 1 else null
						})
				onImageClicked: (event)=>
					super event
					event.preventDefault()
					@currentIndex = @getLightboxImages().index((jQuery(event.target).closest('.uber-grid-cell')))
					if @$el.jp_carousel
						@$el.jp_carousel start_index: @currentIndex, 'items_selector': ".tiled-gallery-item img.uber-grid-cell-image"
						setTimeout(@setHashFromCurrentIndex, 400)
					else
						jQuery(document).ready =>
							setTimeout((=>
								@$el.jp_carousel start_index: @currentIndex, 'items_selector': ".tiled-gallery-item img.uber-grid-cell-image")
								setTimeout(@setHashFromCurrentIndex, 600)
							, 500)

				setHashFromCurrentIndex: =>
					@setHash(@getLightboxLinks().eq(@currentIndex).closest('.uber-grid-cell'))
					jQuery(document).on 'click', '.jp-carousel-next-button', @onNextSlide
					jQuery(document).on 'click', '.jp-carousel-previous-button', @onPrevSlide
					jQuery(document).on 'keyup', @onKeyUp
					jQuery(document).on 'click', '.jp-carousel-close-hint', @onAfterClose
				onAfterClose: =>
					super
					jQuery(document).off 'keyup', @onKeyUp
				onNextSlide: =>
					@currentIndex += 1
					lightboxLinks = @getLightboxLinks()
					if @currentIndex == lightboxLinks.length
						@currentIndex = 0
					setTimeout((=> @setHash(@getLightboxLinks().eq(@currentIndex).closest('.uber-grid-cell'))), 400)
				onPrevSlide: =>
					@currentIndex -= 1
					if @currentIndex < 0
						@currentIndex = @getLightboxLinks().size() - 1
					@setHash(@getLightboxLinks().eq(@currentIndex).closest('.uber-grid-cell'))


			class SwipeboxAdapter extends LightboxAdapter
				constructor: (grid, $el)->
					super grid, $el
				onImageClicked: (event)=>
					super event
					event.preventDefault()
					lightboxImages = jQuery.map(elements = @getLightboxImages(), (image)=>
						image = jQuery(image)
						{
							href: image.find('a.uber-grid-cell-wrapper, a.uber-grid-hover').attr('href'),
							title: => image.find('.uber-grid-lightbox-content').html()
						}
					)
					@currentIndex = elements.index((jQuery(event.target).closest('.uber-grid-cell')))
					jQuery.swipebox(lightboxImages, {initialIndexOnArray: @currentIndex, afterClose: @onAfterClose})
					jQuery('#swipebox-next').click @onNextSlide
					jQuery('#swipebox-prev').click @onPrevSlide
					jQuery(window).on 'keyup', @onKeyUp



			class PrettyPhotoAdapter extends LightboxAdapter
				constructor: (grid, $el, lightboxOptions)->
					if (!jQuery.fn.prettyPhoto)
						alert('PrettyPhoto is not detected. Please check if your theme loads a custom jQuery.')
						return
					@options = lightboxOptions
					super grid, $el
				reset: =>
					super
					@getLightboxLinks().prettyPhoto(hook: 'data-lightbox', deeplinking: false)
					jQuery(document).bind('keydown.prettyphoto', @onKeyUp)
					for link in @getLightboxLinks()
						link = jQuery(link)
						cell = link.closest('.uber-grid-cell')
						image = cell.find('img.uber-grid-cell-image')
						if (link.is('.uber-grid-hover'))
							image = image.clone().css('display', 'none')
							link.append(image)
						image.attr('alt', cell.find('.uber-grid-lightbox-content h3').html()).attr('title', cell.find('.uber-grid-lightbox-content div').html() );

				onKeyUp: (event)=>
					if event.keyCode == 37
						@onPrevSlide()
					else if event.keyCode == 39
						@onNextSlide()
					else if event.keyCode == 27
						@resetHash()
				onImageClicked: (event)=>
					@currentIndex = @getLightboxLinks().index(jQuery(event.target))
					jQuery(window).on 'click', '.pp_previous', @onPrevSlide
					jQuery(window).on 'click', '.pp_next', @onNextSlide
					super event
				onNextSlide: =>
					@currentIndex += 1
					lightboxLinks = @getLightboxLinks()
					if @currentIndex == lightboxLinks.length
						@currentIndex = lightboxLinks.length - 1
					@setHash(@getLightboxLinks().eq(@currentIndex).closest('.uber-grid-cell'))
				onPrevSlide: =>
					@currentIndex -= 1
					if @currentIndex < 0
						@currentIndex = 0
					@setHash(@getLightboxLinks().eq(@currentIndex).closest('.uber-grid-cell'))

			class iLightboxAdapter extends LightboxAdapter
				constructor: (grid, $el, lightboxOptions)->
					if !jQuery.iLightBox
						alert 'iLightbox not detected. Please install end enable iLightbox plugin.'
					super grid, $el
					@options = lightboxOptions
				onImageClicked: (event)=>
					super event
					event.preventDefault()
					elements = @getLightboxImages()
					lightboxImages = jQuery.map elements, (el)=>
						{
						title: @getLightboxImageTitle(el)
						url: @getLightboxImageUrl(el),
						caption: @getLightboxImageCaption(el),
						thumbnail: @getLightboxImageThumbnailUrl(el)
						}
					@currentIndex = index = elements.index(jQuery(event.target).closest('.uber-grid-cell'))
					options = jQuery.extend(@options, ILIGHTBOX.options && eval("(" + rawurldecode(ILIGHTBOX.options) + ")") || {})
					jQuery.iLightBox(lightboxImages, jQuery.extend({
						startFrom: index
						callback: {
							onAfterChange: (instance)=>
								@currentIndex = instance.currentItem
								@setHash(elements.eq(@currentIndex).closest('.uber-grid-cell'))
							onHide: => @resetHash()
						}

					}, options))
			class UberGrid
				constructor: ($el, options) ->
					@$el = jQuery($el)
					@$el.data('ubergrid', this)
					@$inner = @$el.find(".uber-grid")
					@options = options
					@id = @$el.attr("id").replace("uber-grid-wrapper-", "")
					@packery = new Packery(@$inner[0], transitionDuration: "0", gutter: parseInt(options.gutter), itemSelector: '.uber-grid-cell:not(.uber-grid-blurred)')
					@cells = []
					@tryRetina()
					@$pagination = @$el.find(".uber-grid-pagination")
					@pagination = new UberGridPagination(@$pagination, this)  if @$pagination.size() > 0
					@$inner.find(">div").each (index, el)=> @cells.push new UberGridCell(jQuery(el))
					@$el.find("div.uber-grid-filters > div:first-child").addClass "active"
					@$el.find("div.uber-grid-filters > div a").click @onFilterClicked
					@initLightbox()
					jQuery(window).on 'smartresize', => @updateLayout()
					@showWhenVisible()
					setTimeout(@showWhenVisible, 1000)
				showWhenVisible: =>
					if (!@$el.is(':visible') || @$el.width() < 50)
						setTimeout(@showWhenVisible, 500)
					else
						# Make sure the layout is updated at least twice when all the animations will finish
						@updateLayout()
						showNext = ->
							if jQuery(this).next().size() > 0
								jQuery(this).next().animate({'opacity': 1}, 150, showNext)

						setTimeout( (=>
							@updateLayout()
							@packery.options.transitionDuration = "0.6s"
						), 400)

				onFilterClicked: (event)=>
					event.preventDefault()
					@$el.find("div.uber-grid-filters > div").removeClass "active"
					a = jQuery(event.target)
					a.parent().addClass "active"
					tag = a.attr("href").replace(/^#/, "")
					if tag is ""
						jQuery.each @cells, (index, cell) -> cell.show()
					else
						jQuery.each @cells, (index, cell) ->
							if cell.hasTag(tag)
								cell.show()
							else
								cell.blur()
					setTimeout(=>
						@packery.reloadItems()
						@packery.layout()
					, 50)


				updateLayout: =>
					@updateWidth()
					setTimeout((=> @packery.layout()), 20)
				tryRetina: =>
					if window.devicePixelRatio isnt `undefined` and window.devicePixelRatio > 1 and @$el.not(".uber-grid-photon")
						@$el.find(".uber-grid-cell-image").each (index, image) ->
							src2x = jQuery(image).attr("src") + "&zoom=" + window.devicePixelRatio
							jQuery(image).attr("src", src2x).attr('data-at2x', src2x)

				updateWidth: =>
					options = @options
					width = undefined
					cellWidth = undefined
					cellHeight = undefined
					gutter = undefined
					border = undefined
					maxWidth = parseInt(@options.max_width)
					width = jQuery(window).width()
					if width > 768
						cellWidth = options.size.width
						cellHeight = options.size.height
						gutter = options.gutter
						border = options.cell_border
					else if width > 440
						cellWidth = options.size768.width
						cellHeight = options.size768.height
						gutter = options.gutter_768
						border = options.cell_border_768
					else
						cellWidth = options.size440.width
						cellHeight = options.size440.height
						gutter = options.gutter_440
						border = options.cell_border_440
					width = @$el.width()
					width = maxWidth  if not isNaN(maxWidth) and maxWidth > 0 and width > maxWidth
					baseCellWidth = cellWidth = parseInt(cellWidth)
					gutter = parseInt(gutter)
					border = parseInt(border)
					gutter = 0  if isNaN(gutter)
					border = 0  if isNaN(border)

					if options.autosize
						columns = Math.ceil((width + gutter) / (cellWidth + gutter + 2 * border))
						columns += 1  if columns > 2 and columns % 2 is 1 and @$inner.find(".r1c2, .r2c2").size() > 0 and @$inner.find(".r1c1, .r2c1").size() is 0
						columns = @$inner.find(".r1c2, .r2c2").size() * 2 + @$inner.find(".r1c1, .r2c1").size()  if columns > @$inner.find(".r1c2, .r2c2").size() * 2 + @$inner.find(".r1c1, .r2c1").size()
						cellWidth = Math.floor((width + gutter) / columns) - gutter - border * 2
						cellWidth = baseCellWidth  if cellWidth > baseCellWidth
						calculatedCellHeight = Math.floor cellHeight * cellWidth / baseCellWidth
						@$el.find(".uber-grid-cells-wrapper").width width
						@$el.find(".uber-grid-cell.r1c1, .uber-grid-cell.r1c1 .uber-grid-cell-wrapper").width cellWidth
						@$el.find(".uber-grid-cell.r1c1 .uber-grid-cell-wrapper").height calculatedCellHeight
						@$el.find(".uber-grid-cell.r1c2, .uber-grid-cell.r1c2 .uber-grid-cell-wrapper").width cellWidth * 2 + gutter + border * 2
						@$el.find(".uber-grid-cell.r1c2 .uber-grid-cell-wrapper").height calculatedCellHeight
						@$el.find(".uber-grid-cell.r2c1, .uber-grid-cell.r2c1 .uber-grid-cell-wrapper").width cellWidth
						@$el.find(".uber-grid-cell.r2c1 .uber-grid-cell-wrapper").height cellHeight * cellWidth / baseCellWidth * 2 + gutter + border * 2
						@$el.find(".uber-grid-cell.r2c2, .uber-grid-cell.r2c2 .uber-grid-cell-wrapper").width cellWidth * 2 + gutter
						@$el.find(".uber-grid-cell.r2c2 .uber-grid-cell-wrapper").height cellHeight * cellWidth / baseCellWidth * 2 + gutter + border * 2
						for title in @$el.find('.uber-grid-cell-title-wrapper.uber-grid-title-position-center')
							titleHeight = jQuery(title).find('.uber-grid-cell-title').height() / 2
							jQuery(title).find('.uber-grid-cell-title').css('margin-top', "-" + titleHeight.toString() + "px")
						@packery.columnWidth = cellWidth
					else
						columns = Math.floor((width + gutter) / (cellWidth + gutter + 2 * border))
						columns -= 1  if columns > 4 and columns % 2 is 1 and @$inner.find(".r1c2, .r2c2").size() > 0 and @$inner.find(".r1c1, .r2c1").size() is 0
						columns = @$inner.find(".r1c2, .r2c2").size() * 2 + @$inner.find(".r1c1, .r2c1").size()  if columns > @$inner.find(".r1c2, .r2c2").size() * 2 + @$inner.find(".r1c1, .r2c1").size()
						width = columns * (cellWidth + border * 2) + (columns - 1) * gutter
						@$el.find(".uber-grid-cells-wrapper").width width
					@packery.gutter = @packery.options.gutter = gutter
				initLightbox: =>
					lightbox_options = @options.lightbox.lightbox_options

					switch @options.lightbox
						when 'magnific-popup' then @lightboxAdapter = new MagnificPopupAdapter(this, @$inner, lightbox_options)
						when 'swipebox' then @lightboxAdapter = new SwipeboxAdapter(this, @$inner, lightbox_options)
						when 'prettyphoto' then @lightboxAdapter = new PrettyPhotoAdapter(this, @$inner, lightbox_options)
						when 'ilightbox' then @lightboxAdapter = new iLightboxAdapter(this, @$inner, lightbox_options)
						when 'jetpack' then @lightboxAdapter = new JetpackAdapter(this, @$inner, lightbox_options)
						when 'foobox' then @lightboxAdapter = new FooBoxAdapter(this, @$inner, lightbox_options)
						else null
					return
				showGrid: =>
					@$el.animate
						opacity: 1
					, "fast"
					setTimeout (->
						if @$el.not(":visible")
							@$el.animate
								opacity: 1
							, "fast"
						return
					), 500
					return
			class UberGridPagination
				constructor: ($pagination, grid) ->
					@$pagination = $pagination
					@grid = grid
					@$grid = @grid.$el
					@pages = []
					@pages[1] = grid.$inner.find("div.uber-grid-cell")
					@packery = grid.packery
					grid.packery.on "layoutComplete", @layoutComplete
					@currentPage = 1
					$pagination.find("div.uber-grid-pagination-page").first().addClass "uber-grid-current"
					$pagination.find("div.uber-grid-pagination-page a").click (event) =>
						event.preventDefault()
						clickedPage = parseInt(jQuery(event.target).attr("href").replace("#ubergrid-page-", ""))
						@$pagination.find("div.uber-grid-pagination-page").removeClass("uber-grid-current").eq(clickedPage - 1).addClass "uber-grid-current"
						return  if @currentPage is clickedPage
						if @pages[clickedPage]
							@showPage clickedPage
						else
							@loadPage clickedPage
				loadPage: (page, callback) =>
					@$grid.find(".uber-grid-cells-wrapper").append jQuery("<div class=\"uber-grid-ajax-blur\"><span></span></div>").width(@grid.$inner.width()).fadeIn("fast")
					jQuery.get @grid.options.ajaxurl,
						id: @grid.id
						page: page
						action: "uber_grid_get_page"
					, (response) =>
						@pages[page] = jQuery(response)
						jQuery.each @pages[page], (index, element) =>
							@grid.cells.push new UberGridCell(jQuery(element))
							return
						@showPage page
						callback() if typeof(callback) != 'undefined'
						return

					return
				showPage: (page) =>
					@grid.tryRetina()
					@currentPage = page
					@packery.remove @grid.$inner.find("div.uber-grid-cell")
					@grid.$inner.append @pages[@currentPage]
					@packery.appended @pages[@currentPage]
					@grid.updateWidth()
					@packery.layout @pages[@currentPage]
					@grid.lightboxAdapter.reset() if @grid.lightboxAdapter

				layoutComplete: => @$grid.find(".uber-grid-ajax-blur").fadeOut "fast", -> jQuery(this).remove()

			class UberGridCell
				constructor: (el) ->
					@$el = el
					@$el.data('uber-grid-cell', this)
					description = @$el.find(".uber-grid-cell-description")
					if @hasHover()
						if @hasLink()
							@$el.click @onLinkClicked
							@$el.mouseleave =>
								@$el.removeClass 'uber-grid-hover-active'
						else
							@$el.click @toggleHover
							@$el.mouseleave =>
								@$el.removeClass 'uber-grid-hover-active'
					else
						@$el.click (event)=>
							if @$el.find('.uber-grid-lightbox').size() > 0
								event.preventDefault()
								jQuery(@$el.find('a.uber-grid-hover, a.uber-grid-cell-wrapper')[0]).trigger('click:ubergrid', event)



				hasHover: => @$el.find('.uber-grid-hover').size() > 0
				hasLink: => @$el.find('a.uber-grid-hover, a.uber-grid-cell-wrapper').size() > 0
				toggleHover: =>
					#@$el.toggleClass('uber-grid-hover-active')
				onLinkClicked: (event)=>
					if @$el.hasClass('uber-grid-hover-active') or !is_touch_device()
						event.preventDefault()
						if @$el.find('.uber-grid-hover.uber-grid-lightbox').size() > 0
							jQuery(@$el.find('a.uber-grid-hover, a.uber-grid-cell-wrapper')[0]).trigger('click:ubergrid', event)
						else
							link = @$el.find 'a.uber-grid-hover'
							if link.attr('target') == "_blank" or link.attr('target') == "blank"
								window.open(link.attr('href'))
							else
								window.location.href = @$el.find('a.uber-grid-hover').attr('href')
					else
						@$el.addClass('uber-grid-hover-active')
						event.preventDefault()
						event.stopPropagation()



				hasTag: (tag) =>
						tags = @$el.attr("data-tags")
						return false  unless tags
						tags = tags.split(",")
						tags = jQuery.map(tags, (tag) -> tag.replace(/\s+$/, "").replace /^\s+/, "")
						i = 0
						while i < tags.length
							return true  if tag is tags[i]
							i++
						false
				show: ->
					if @hideTimeout
						clearTimeout @hideTimeout
						@hideTimeout = null
					if @$el.hasClass('uber-grid-blurred')
						@$el.show().removeClass('uber-grid-blurred')

				blur: ->
					@$el.addClass('uber-grid-blurred')
					@hideTimeout = setTimeout((=> @$el.hide()), 300)

			window.UberGrid = UberGrid
			jQuery ->
				setTimeout (->
					jQuery('.uber-grid-cell a.uber-grid-cell-wrapper.uber-grid-lightbox, .uber-grid-cell a.uber-grid-hover.uber-grid-lightbox').off 'click'
					jQuery('body').off 'click', '.uber-grid-cell a.uber-grid-cell-wrapper.uber-grid-lightbox, .uber-grid-cell a.uber-grid-hover.uber-grid-lightbox'
				), 1
	return
) window.uberGridjQuery or window.jQuery or window.$ or jQuery or $
