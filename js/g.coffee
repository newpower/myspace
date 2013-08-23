library = (window.g ||= {})

library.Messenger = class
  global_place = $(document)
  format = (message) ->
    if @place is global_place then 'global_'+message else 'local_'+message
  constructor: (place = global_place) ->
     @place = if place.css then place else $(place)
  listen: (message, reaction) ->
    @place.bind (format.call @, message), () -> $("#division_1").val(arguments[1]).change()
  notify: (message, data) ->
    @place.trigger (format.call @, message), [data]

library.HashData = class
  convert =
    toObject: (string) ->
      JSON.parse string
    toString: (object) ->
      JSON.stringify object

  hash =
    object :
      get: () ->
        try
          hash_string = window.location.hash.match(/[^#].*/)[0]
          convert.toObject hash_string
      set: (object) ->
        window.location.hash = convert.toString object

  constructor: (@key) ->

  get: () ->
    hash.object.get()?[@key]

  set: (data) ->
    new_hash_object = hash.object.get() || {}
    new_hash_object[@key] = data
    hash.object.set new_hash_object

  asParam: () ->
    try
      decodeURIComponent $.param @get()
    catch e
      null

library.Division = class
  message =
    change_division: 'change_division'
    division_changed: 'division_changed'
    show_division: 'show_division'
    hide_division: 'hide_division'

  default_options =
    messenger: new library.Messenger
    data_url: ''
    selected_id: 0
    parent_element: null
    hash_data: new library.HashData 'division'

  template =
    content: "  {{each divisions}}
                <select class='item-sel'>
                  <option value='${$value[0].parent_id}' class='empty'></option>
                  {{each $value}}
                  <option  {{if $value.selected }} selected {{/if}} {{if $value.isWritable }} isGood {{else}} isDivision {{/if}} value=${$value.id}>${$value.name}</option>
                  {{/each}}
                </select>
                {{/each}}

                {{if children.length}}
                <select class='item-sel'>
                  <option value='${children[0].parent_id}' class='empty'></option>
                  {{each children}}
                  <option {{if $value.isWritable }} isGood {{else}} isDivision {{/if}} value=${$value.id}> ${$value.name} </option>
                  {{/each}}
                </select>
                {{/if}}  "

  remember = (id) ->
    @selected_id = id
    @hash_data.set id
    @messenger.notify message.division_changed, id

  change_to = (id) ->
    self = @
    select = self.parent_element.find('select.item-sel').has "option[value=#{id}]:not(.empty)"
    how = if select.length is 0 then 'for_first_time' else 'not_for_first_time'
    $.ajax {
      dataType: 'json'
      type: 'GET'
      url: self.data_url
      data:
        division_id : id
        how : how
      cache: false,
      success: (divisions) ->
        html = $.tmpl template.content, divisions
        if how is 'for_first_time'
          self.parent_element.html html
        else
          select.nextAll().remove()
          select.val id
          html.appendTo self.parent_element
        self.parent_element.find('select.item-sel').each ->
          isDivision = (($ @).find 'option[isDivision]').length > 0
          isGood = (($ @).find 'option[isGood]').length > 0
          if isDivision && isGood
            (($ @).find 'option.empty').text t('Укажите раздел или товар')
          else
            (($ @).find 'option.empty').text t('Укажите товар') if (isGood)
            (($ @).find 'option.empty').text t('Укажите раздел') if (isDivision)
        remember.call self, id
    }

  init_events = ->
    self = @
    @parent_element.find('select.item-sel').live 'change', ->
      if ($ @).find('option:selected').hasClass 'empty'
        ($ @).nextAll().remove()
        remember.call self, ($ @).val()
      else change_to.call self, ($ @).val()
    @messenger.listen message.change_division, (division_id) ->
      change_to.call self, division_id
    @messenger.listen message.hide_division, ->
      self.hide()
    @messenger.listen message.show_division, ->
      self.show()

  extend = (options) ->
    @[key] = value for key, value of options

  constructor: (options = {}) ->
    extend.call @, default_options
    extend.call @, options
    @parent_element = $ @parent_element if not @parent_element.css
    init_events.call @
    selected_division = @hash_data.get() or @selected_id
    change_to.call @, selected_division

  hide: () ->
    @parent_element.hide()

  show: () ->
    @parent_element.show()

library.Criteria = class

	default_options =
		submit_element: null
		criteria_element: null
		division_element: null
		division_select: null
		hash_divisions: new library.HashData 'divisions'
		hash_occupations: new library.HashData 'occupations'
		
	template = 
		content: 	"<div><div class='criterion'>
						<a id='remove_criterion_${Count}' href='#'>
							<img width='16' height='16' src='/img/icons/delete3.png'>
						</a>
						<input type='hidden' name='division[${Count}]' value='${Division}'>
						{{each Occupation}}
							<input type='hidden' name='occupation[${Count}][${$index}]' value='${$value}'>
						{{/each}}
						${Name}{{each OccupationName}}, ${$value}{{/each}}
					<div></div>"
		
	criterionCount = 1
	
	remove_criterion = (id, self) ->
		$('#remove_criterion_' + id).live 'click', ->
			$('#remove_criterion_' + id).parent().remove()
			divisions = self.hash_divisions.get()
			occupations = self.hash_occupations.get()
			delete divisions[id]
			delete occupations[id]
			self.hash_divisions.set divisions
			self.hash_occupations.set occupations
			false
			
	create_criterion = (parameters, self) ->
		html = $.tmpl template.content, parameters 
		self.criteria_element.append html
		remove_criterion criterionCount, self
		criterionCount++
		
	init_criterion =->
		self = @
		divisions = @hash_divisions.get()
		occupations = @hash_occupations.get()
		for index, division of divisions
			criterionCount = index
			div = division.split '-'
			occupation_id = new Array()
			occupation_name = new Array()
			for i, occupation of occupations[index]
				temp = occupation.split '-'
				occupation_id.push temp[0]
				occupation_name.push temp[1]
			parameters =
				Count: criterionCount
				Division: div[0]
				Occupation: occupation_id
				Name: div[1]
				OccupationName: occupation_name
			create_criterion parameters, self
			
	add_criterion = (parameters, self) ->
		create_criterion parameters, self
		divisions = self.hash_divisions.get()
		occupations = self.hash_occupations.get()
		if !divisions
			divisions = {}
		if !occupations
			occupations = {}
		divisions[parameters.Count] = parameters.Division + '-' + parameters.Name
		new_occupation = new Array()
		for i, occupation of parameters.Occupation
				new_occupation.push occupation + '-' + parameters.OccupationName[i]
		occupations[parameters.Count] = new_occupation
		self.hash_divisions.set divisions
		self.hash_occupations.set occupations
		
	init_events = ->
		self = @
		@submit_element.live 'click', ->
			division = self.division_element.val()
			if division? and (division != "") and (division != 0) and (division != "0")
				occupation_name = Array()
				occupation = $('input:checkbox:checked.occupation').map ->
					occupation_name.push $('input:checkbox[value='+this.value+']').attr('data-name')
					@.value
				occupation = occupation.get()
				name = self.division_select.find('select option[value=' + division + ']:first').text()
				parameters =
					Count: criterionCount
					Division: division
					Occupation: occupation
					Name: name
					OccupationName: occupation_name
				add_criterion parameters, self
				self.division_element.val 0
				$('input:checkbox:checked.occupation').attr checked: false 
				self.division_select.find('select').val ''
				self.division_select.find('select:first').nextAll().remove()
    		
	extend = (options) ->
		@[key] = value for key, value of options
	
	constructor: (options = {}) ->
		extend.call @, default_options
		extend.call @, options
		init_events.call @
		init_criterion.call @
