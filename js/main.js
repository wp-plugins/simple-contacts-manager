var j = jQuery.noConflict();

j(function() {
	var animSpeed = 200;
	var group = j('#cm_group').val();

	j('.cm-submit.js').on('click', function(){
		j('#cm-action-js').val( j(this).val() );
		j(this).parents('form').submit();
	});

	j('.cm-edit.js').on('click', function(){
		redirect( j(this).data('href') );
	});

	j('.cm-delete.js').on('click', function(){
		if( confirm( 'Are you sure you want to delete the Contact Group?' ) ) {
			redirect( j(this).data('href') );
		}
	});

	j('.cm__add-btn.js').on('click', function() {
		cm_animate(this);
	});

	j('.cm__shortcode-btn.js').on('click', function() {
		cm_shortcode(this);
	});

	j('.cm-remove.js').on('click', function() {
		cm_remove(this);
	});

	j('.cm-add__cancel.js').on('click', function() {
		cm_animate(this);
	});

	j('.cm-add__save.js').on('click', function() {
		var e_value = j(this).prev('.value');
		var e_label = e_value.prev().prev('.label');
		var key = cleanup( e_label.val() );

		if( key ) {
			var section = e_value.parents('.postbox').data('section');

			if( j('#'+section+'_'+key).length ) {
				alert('The Label already exists in this section');
				return false;
			}
			
			var html = '<div id="'+section+'_'+key+'" class="clearfix cm__item" style="display: none;">'+
					'	<label class="cm__label" for="'+section+'_'+key+'_value">'+ e_label.val() +'</label>'+
					'	<input type="text" name="'+section+'_'+key+'_value" value="'+ e_value.val() +'" />'+
					'	<span><strong>Key:</strong> <input type="text" class="cm__key" value="'+ group +'-'+section+'-'+key+'" data-shortcode=\'[cm_contact key="'+ group +'-'+section+'-'+key+'"]\' readonly /></span>'+
					'	<input type="button" class="button cm__shortcode-btn js" value="Get Shortcode" />'+
					'	<input type="button" class="button cm-remove js" value="Remove Field" />'+
					'	<input type="hidden" name="'+section+'_'+key+'_label" value="'+ e_label.val() +'" />'+
					'	<input type="hidden" name="'+section+'_keys[]" value="'+key+'" />'+
					'</div>';

			j(this).next().click();
			j(this).parents('.cm-add').before(html);
			j('#'+section+'_'+key).delay(500).slideDown('fast');
			j('.cm-remove.js').on('click', function() {
				cm_remove(this);
			});
			j('.cm__shortcode-btn.js').on('click', function() {
					cm_shortcode(this);
			});
		}
		else
			alert('Label is required');
	});

	function cm_animate( obj ) {
		var parent = j(obj).parents('.cm-add__container');
		var elemOut = parent.find('.cm-add__wrapper--buttonIn');
		var elemIn = parent.find('.cm-add__wrapper--buttonOut');
		parent.find('.cm-add__field').val('');
		elemOut.removeClass('cm-add__wrapper--buttonIn').addClass('cm-add__wrapper--buttonOut');
		elemIn.removeClass('cm-add__wrapper--buttonOut').addClass('cm-add__wrapper--buttonIn');
	}

	function cm_remove( obj ) {
		if( confirm( 'Are you sure you want to remove this field?' ) ) {
			j(obj).parent().fadeOut(500, function() {
				j(obj).parent().remove();
			});
		}
	}

	function cm_shortcode( obj ) {
		var elem = j(obj).prev('span').find('.cm__key');
		var val = elem.val();
		var sc = elem.data('shortcode');
		var cl = 'shortcode--shown';

		elem.val(sc);
		elem.data('shortcode',val);

		if( elem.hasClass(cl) ) {
			elem.removeClass(cl);
			j(obj).val('Get Shortcode');
		}
		else {
			elem.addClass(cl);
			j(obj).val('Get Key');
		}
	}

	function cleanup( text ) {
		return text.toLowerCase().replace(/[^\w ]+/g,'').replace(/[ ]+/g,'_');
	}

	function redirect( href ) {
		location.href = href;
	}
});