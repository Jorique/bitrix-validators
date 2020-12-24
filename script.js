// валидация форм
var FormValidate = window.FormValidate = function($form) {
	this.$form = $form;
	this.blockSubmit = true;
	this.bindSubmit();
};
FormValidate.prototype = {
	bindSubmit: function() {
		var that = this;

		// не вешаем по 2 раза
		if(this.$form.data('formValidate')) {
			return;
		}

		this.$form.data('formValidate', this);
		this.$form.on('submit', function() {
			if(!that.blockSubmit) return true;

			$.post(
					that.$form.data('ajaxUrl'),
					that.$form.serialize(),
					function(resp) {
						that.$form.find('[type="submit"]').removeAttr('disabled');
						that.clearErrors();
						if(resp.success) {
							that.blockSubmit = false;
							that.$form.trigger('submit');
						}
						else {

							that.setErrorsToFields(resp);
						}
					},
					'json'
			);
			that.$form.find('[type="submit"]').attr('disabled', true);
			return false;
		});
	},
	setErrorsToFields: function(errors) {
		var fieldName, fieldPos, errorName, arErrorName, $field;
		for(errorName in errors) {
			if(errors.hasOwnProperty(errorName)) {
				if(errorName == 'newCaptchaCid|0') {
					$('.captchaImage').attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + errors[errorName]);
					$('input[name="captcha_sid"], input[name="captcha_code"]').val(errors[errorName]);
				}

				arErrorName = errorName.split('|');
				fieldName = arErrorName[0];
				fieldPos = arErrorName[1];

				$field = this.$form.find('[name="'+fieldName+'"]').eq(fieldPos);

				var $errorWrapper = this.$form.find('.errorWrapper[data-for="'+fieldName+'"]'),
					$errorTag = this.$form.find('.errorTag[data-for="'+fieldName+'"]'),
						$errorSpan = $('<label class="error">'+errors[errorName]+'</label>');
				if( $errorWrapper.length ) {
					$errorWrapper.eq(fieldPos).html($errorSpan);
				}
				else {
					$field.after($errorSpan);
				}
				if( $errorTag.length ) {
					$errorTag.eq(fieldPos).addClass('error');
				}
				else {
					$field.addClass('error');
				}
			}
		}
	},
	clearErrors: function() {
		this.$form.find('label.error').remove();
		this.$form.find('.error').removeClass('error');
		this.$form.find('.errorWrapper').empty();
	}
};

$(function() {
	$('form[data-ajax-url]').each(function() {
		new FormValidate($(this));
	});
	BX.addCustomEvent('onFrameDataReceived', function(json) {
		$('form[data-ajax-url]').each(function() {
			new FormValidate($(this));
		});
	});
});