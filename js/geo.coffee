# mixin
mixin = {}


mixin.ready = ->
	# by default ready right away
	@ready ||= (dfd) -> dfd.resolve @

	if typeof @ready is 'function'
		dfd = $.Deferred()
		# run
		@ready dfd
		# rewrite ready with deferred
		@ready = dfd.promise()

mixin.events = (options) ->

	# catalog module trigger change event
	# 'change {catalog}' : 'method_name'
	# click (other jQuery event)  on element (juqery selector, if nothing - sandbox)
	# 'click button' : 'method_name'
	# events: {}

	# object to trigger global events
	@_global_events ||= $('body')

	# object to trigger local events
	@_local_events ||= @sandbox

	# cross-module communication
	@notify = (e, data={}) ->
		@_global_events.trigger "#{e}_{#{@constructor.name.toLowerCase()}}", [data]

	@_bind = (events={}) ->
		for k,v of events

			((k,v) =>
				method = @[v]
				# [ev, selector] = k.split /[ ](.+)/, 2
				p = k.indexOf(' ')
				if p > 0
					ev = k.substring 0, p
					selector = k.substring k.indexOf(' ') + 1, k.length
				else
					ev = k


				# module events
				if selector?.match /^{/
					@_global_events.on k.replace(' ','_'), =>
						method.apply @, arguments

				else
					@_local_events.on ev, selector, => method.apply @, arguments

			)(k,v)

	@_bind(@events)




isNumber = (n) -> typeof n is 'number' and not isNaN(n) and isFinite(n)




class Module
	# @sandox - jquery points to some html
	constructor: (sandbox, options={}) ->
		$.extend true, @options, options
		@sandbox = if sandbox.css then sandbox else $(sandbox)

		@constructor.all.push @

		# after all
		mixin.events.apply @
		mixin.ready.apply @


	@all = []

	# default options
	options: {}






# ----------------------- geo -------------------------

class Geo
	@all: {}

	@find_or_create: (data) ->
		i = @all[data.id]
		if i 
			i.ready
		else
			(new @(data)).ready

	@info: (id)->
		# @_info ||= {}


		if @_info?[id]
			@_info[id]
		else
			unless @dfd
				@dfd = $.Deferred()
				$.ajax
					url: "/geodata/info.js"
					dataType: 'json'

					success: (data) =>
						@_info = data
						@dfd.resolve @_info[id]
					error: =>
						@dfd.reject @

			@dfd.promise()





	constructor: (@data) ->
		@id = @data.id
		@level = @data.level
		# console.log '@id', @id
		@constructor.all[@id] = @
		@_init()
		mixin.ready.apply @

	_init: ->
		unless isNumber @level
			@data.level = (@parent.level||0) + 1 if @parent
			@level = Number(@data.level)
			if @data.level > 1
				@_children = []

		if @level is -1
			@center = [67.315188, 95.944043]
			@zoom = 2

		@points ?= @data.points


	ready: (dfd)  ->
		# debugger
		if !@_children
			if (@data.parent and @data.parent.level >= 1) or @data.level > 1 or @level > 1
				dfd.resolve @
				return
			$.ajax
				url: "/geodata/#{ @id }.js"
				dataType: 'json'

				success: (data) =>
					# console.log 'succes geodata ajax', data
					_.extend @data, data

					$.when(@.constructor.info @id).then (info)=>
						@data.info = info
						@_init()

					@_init()

					dfd.resolve @
				error: =>
					dfd.reject @
					# dfd.resolve @

		else
			dfd.resolve @

	# parent: ->
	children: ->
		unless @_children
			 @_children = {}
			for id,ch of @data.children
				ch.parent = @
				c = @_children[id] = @constructor.all[id] or new @constructor(ch)
				c.parent = @
				c._init()

		@_children

	neighbors: ->
		r = undefined
		(r ||= {})[id] = ch for id,ch of @parent?.children() when ch isnt @
		r


	_iter: (points) ->
		min = [255,255]
		max = [0,0]

		for pp in points

			for p in pp

				p0 = p[0]
				p1 = p[1]

				min[0] = p0 if p0 < min[0]
				min[1] = p1 if p1 < min[1]
				max[0] = p0 if p0 > max[0]
				max[1] = p1 if p1 > max[1]

		[min,max]

	deeper: ->
		r = {}
		for id, g of @constructor.all
			r[id] = g if g.level > @level
		r

	upper: ->
		r = {}
		for id, g of @constructor.all
			r[id] = g if g.level < @level
		r



	bounds: ->
		unless @_bounds
			if @data.bounding_box
				b = @data.bounding_box
				@_bounds = [[b[2],b[0]], [b[3],b[1]]]

			else if @points?.length
				@_bounds = @_iter @points

			else if @children()
				p = []
				for id,ch of @children()
					p.push(ch.bounds())
				p = _.compact(p)

				@_bounds = @_iter p if p.length

		@_bounds



	draw2: (options={}) ->
		defaults = fillColor: '#99000011', strokeWidth: 1, strokeColor: '#00000066'



		distance = (p1,p2) -> Math.sqrt Math.pow(p1[0] - p2[0],2) + Math.pow(p1[1] - p2[1],2)

		chs = @children()

		points = []

		for id,ch of chs
			chp = ch.points

			for p1,i in chp

				l1 = new ymaps.Circle [p1,10000], { hintContent: i  }, { strokeColor: '#000000',strokeWidth: 1}
				map.ya.geoObjects.add(l1)





		# points = points[0..40]
		points.push points[0]

		@obj = new ymaps.Polygon [], { hintContent: '11' }, _.extend defaults, options or {}
		@obj




class MapRegion
	constructor: (@geo) ->
		@geo.region = @

	show: -> @obj?.options.set 'visible', true
	hide: -> @obj?.options.set 'visible', false
	hide_deeper: ->
		for id,g of @geo.deeper()
			g.region?.hide()

	draw: (options={}) ->
		defaults = fillColor: '#99000011', strokeWidth: 1, strokeColor: '#00000066'

		points = JSON.stringify(@geo.points)
		if points.substring(0,3) != '[[['
			points = '[' + cds + ']'
		points = JSON.parse(points)

		@obj = new ymaps.Polygon points, { hintContent: @geo.data.name }, _.extend defaults, options or {}
		@obj.events.add 'click', =>
			@highlight()
			@click @geo

		@obj

	click: ->

	added: false

	options: (attrs={})	->
		for key, value of attrs
			@obj?.options.set key, value


	unhiglight: (opt={})->
		@highlighted = false
		if opt.fade
			@options strokeColor: '#00000000'
		else
			@options strokeColor: '#00000066'
		@options fillColor: '#99000011'



	highlight: (opt={})->
		@highlighted = true
		@options fillColor: '#99000088'

		for id,g of Geo.all
			if g.region
				if g.level != @geo.level
					if @geo.level > 0 and g.level <= @geo.level - 1
						g.region.unhiglight({fade: true})
					else
						g.region.unhiglight()

				if g.level == @geo.level and g.region isnt @ and opt.no_neighbors
					g.region.unhiglight()

		@hide_deeper()
		@show()







class Map extends Module
	constructor: ->
		super

	events:
		'change {address}': 'on_change_address'

	options:
		init:
			ya:
				center: [55.76, 37.67]
				zoom: 8
				behaviors: ['drag']

	pos: (params = {}) ->
		if params.bounds
			center_and_zoom = ymaps.util.bounds.getCenterAndZoom params.bounds, [500, 300]

		if params.center
			center_and_zoom =
				zoom: params.zoom
				center: params.center

		@ya.setCenter center_and_zoom.center, center_and_zoom.zoom, duration: 400


	current: { id: -1 }
	on_change_address: (e, geo) ->
		# console.log 'on_change_address'
		$.when(@ready).then =>
			return if @current.id is geo.id
			@current = geo

			for id, g of geo.neighbors()
				g.region?.unhiglight()
				g.region?.show()

			if geo.children() && geo.children().length != 0
				geo.region?.hide()

				$.when.apply(null, _.pluck(geo.children(), 'ready')).always =>
					for id, ch of geo.children()

						if ch.points?.length
							r = ch.region ||= new MapRegion ch
							@add r unless r.added
							r.highlight()

					# @add geo.draw2()
			else
				geo.region.highlight()
			


			unless geo.center
				@pos bounds: geo.bounds()
			else
				@pos center: geo.center, zoom: geo.zoom


	add: (o) ->
		if o instanceof MapRegion
			o.added = true
			o.click = (data) =>
				@notify 'click', data

			o = o.draw()

		@ya.geoObjects.add o if o


	ready: (dfd)->
		ymaps.ready =>
			id = @sandbox.attr 'id'
			@sandbox.attr 'id', id = 'map' + (new Date).valueOf() unless id
			@ya = new ymaps.Map id, @options.init.ya


			dfd.resolve @




class AddressNode
	@template: '#address_item'

	constructor: (@geo)->
		if typeof @constructor.template is 'string'
			@constructor.template = $.template null, $(@constructor.template).html()

		@geo.address = @
		@el = $.tmpl @constructor.template, @geo.data

		@_local_events = @el
		mixin.events.apply @


	events:
		'click' : 'on_click'
		'click .toggle': 'toggle_block'

	on_click: ->
		@notify 'click', @ unless @selected

	toggle_block: (e)->
		block = $(e.target).data('toggle')
		@el.find(block or '.ministry' ).toggle(200)

	selected: false
	select: ->
		@selected = true
		@el.addClass('selected')
		@el.find('.on-select').show()

	deselect: ->
		@selected = false
		@el.removeClass('selected')
		@el.find('.on-select').hide()
		@el.find('.ministry').hide()

	hide: -> @el.fadeOut()
	show: ->
		@hide_deeper()
		@hide_neighbors()
		@deselect_upper()
		@select()
		@el.fadeIn(500)

	hide_neighbors: (opt={})->
		for id,g of @geo.neighbors()
			g.address?.hide()

	hide_deeper: (opt={})->
		for id,g of @geo.deeper()
			g.address?.hide()

	deselect_upper: ->
		for id,g of @geo.upper()
			g.address?.deselect()


	added: false






class Address extends Module
	constructor: ->
		super
		@change id: 0

	events:
		'click {addressnode}': 'upper'
		'click {map}': 'from_map'

	from_map: (e, data) ->
		@change data

	upper: (e, node) ->
		@change id: node.geo.id

	change: (data) ->
		@d = $.Deferred()
		$.when(Geo.find_or_create data).then (g) =>
			@notify 'change', g

			a = g.address ? new AddressNode(g)


			unless a.added
				@sandbox.prepend a.el
				a.added = true

			$.when(a.show()).done =>
				@d.resolve()

		@d




# depends on : jquery, jquery-templates
class Catalog extends Module
	options:
		template: '#catalog_item'
		url: '/offer/search?json=1&division_id=%id'
		root: 0

	constructor: ->
		super

		if typeof @options.template is 'string'
			@options.template = $.template null, $(@options.template).html()

		@change()

	events:
		'change select': 'change'

	get_list: (id, f) ->
		$.getJSON @options.url.replace('%id', id), (data) ->
			if data.children.length
				data.divisions.push data.children
			f data.divisions

	change: (e) ->
		id = @options.root
		id = $(e.target).val() if e

		@get_list id, (list) =>
			@sandbox.html $.tmpl @options.template, list: list

		@notify 'change', div: id





class Content extends Module
	events:
		'change {address}': 'on_change'
		'change {catalog}': 'on_change'

	data: {}

	on_change: (e, data)->
		t = e.type.match(/{(.+)}/)?[1]
		@data[t] = data
		@update()


	url_helper: (type, division, region) ->
		"/offer/search#division_id=#{ division }&json=1&type=#{ type }&model%5Bdivision_id%5D=#{ division }&model%5Bgeneral%5D%5Bregion%5D%5B%5D=#{ region }"

	update: ->
		q =
			region: @data.address?.id
			division: @data.catalog?.div
			ajax: 1


		# if q.region and q.division
		$.post offers_url, q, (data) =>
			@sandbox.find('.place').replaceWith data
			@sandbox.find('.sell a:last').attr href: @url_helper(1,  q.division, q.region)
			@sandbox.find('.buy a:last').attr href: @url_helper(2,  q.division, q.region)



window.map = new Map '#map'
address = a = new Address '#address'

catalog = new Catalog '#catalog'
content = new Content '#content'


$.when(map.ready, address.ready, catalog.ready).then ->
	$('select[name=division]').val(43866).change()
	recursiveChangeAddresses start_region


recursiveChangeAddresses = (arr, i)=>
	i = 0 if !i
	addressItem = arr[i] 
	$.when(address.change(id: addressItem, level: i)).done =>
		++i
		setTimeout =>
			recursiveChangeAddresses(arr, i) if arr[i]
		, 510



 






