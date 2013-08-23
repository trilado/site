(function ($) {
	$.fn.extend({
		bbcode: function (o) {
			var self = this;
	
			if(o === undefined)
				o = {};
	
			var d = {
				h1: o.h1 != undefined ? o.h1 : '.bb-h1',
				h2: o.h2 != undefined ? o.h2 : '.bb-h2',
				h3: o.h3 != undefined ? o.h3 : '.bb-h3',
				url: o.url != undefined ? o.url : '.bb-url',
				img: o.img != undefined ? o.img : '.bb-img',
				italic: o.italic != undefined ? o.italic : '.bb-italic',
				bold: o.bold != undefined ? o.bold : '.bb-bold',
				code: o.code != undefined ? o.code : '.bb-code',
				ul: o.ul != undefined ? o.ul : '.bb-ul',
				ol: o.ol != undefined ? o.ol : '.bb-ol',
				quote: o.quote != undefined ? o.quote : '.bb-quote',
				hr: o.hr != undefined ? o.hr : '.bb-hr'
			};
	
			jQuery(self).each(function(i, e) {
				var $e = jQuery(e);
				var controls = $e.attr('bbcode')
				var $controls = $('#' + controls);
		
				jQuery(d.h1, $controls).click(function(event) {
					event.preventDefault();
					addTag('[h1]', '[/h1]', $e);
				});
				jQuery(d.h2, $controls).click(function(event) {
					event.preventDefault();
					addTag('[h2]', '[/h2]', $e);
				});
				jQuery(d.h3, $controls).click(function(event) {
					event.preventDefault();
					addTag('[h3]', '[/h3]', $e);
				});
				jQuery(d.url, $controls).click(function(event) {
					event.preventDefault();
					addUrl($e);
				});
				jQuery(d.img, $controls).click(function(event) {
					event.preventDefault();
					addImg($e);
				});
				jQuery(d.bold, $controls).click(function(event) {
					event.preventDefault();
					addTag('[b]', '[/b]', $e);
				});
				jQuery(d.italic, $controls).click(function(event) {
					event.preventDefault();
					addTag('[i]', '[/i]', $e);
				});
				jQuery(d.code, $controls).click(function(event) {
					event.preventDefault();
					addTag('[code]', '[/code]', $e);
				});
				jQuery(d.ul, $controls).click(function(event) {
					event.preventDefault();
					addList('[list]', '[/list]', $e);
				});
				jQuery(d.ol, $controls).click(function(event) {
					event.preventDefault();
					addList('[list=1]', '[/list]', $e);
				});
				jQuery(d.quote, $controls).click(function(event) {
					event.preventDefault();
					addTag('[quote]', '[/quote]', $e);
				});
				jQuery(d.hr, $controls).click(function(event) {
					event.preventDefault();
					addSimpleTag('[hr]', $e);
				});
			});
	
			function addTag(open, close, textarea) {
				var selection;
				if (document.selection) {
					textarea.focus();
					selection = document.selection.createRange();
					selection.text = open + selection.text + close;
				} else {
					var length = textarea.val().length;
					var start = textarea[0].selectionStart;
					var end = textarea[0].selectionEnd;
		
					var scrollTop = textarea[0].scrollTop;
					var scrollLeft = textarea[0].scrollLeft;
		
					selection = textarea.val().substring(start, end);
			
					var rep = open + selection + close;
					textarea.val(textarea.val().substring(0, start) + rep + textarea.val().substring(end, length));
					textarea[0].scrollTop = scrollTop;
					textarea[0].scrollLeft = scrollLeft;
				}
			}
	
			function addUrl(textarea) {
		
				var selection;
				var fields = {
					'URL': {
						placeHolder: 'http://'
					}
				};
		
				if (document.selection) {
					selection = document.selection.createRange();
				
					if(selection.text == "") {
						fields['Texto do Link'] = {
							placeHolder: 'Texto'
						};
					}			
				} else {
					var length = textarea.val().length;
					var start = textarea[0].selectionStart;
					var end = textarea[0].selectionEnd;
		
					selection = textarea.val().substring(start, end);
		
					if(selection == "") {
						fields['Texto do Link'] = {
							placeHolder: 'Texto'
						};
					}
				}
		
				$('body').bModal({
					heading: 'Inserir Link',
					body: fields,
					callback: function (body) {
						
						var url = body['URL'].value;
						var text = body['Texto do Link'] === undefined ? '' : body['Texto do Link'].value;
				
						var scrollTop = textarea.scrollTop;
						var scrollLeft = textarea.scrollLeft;

						

						if (url != '' && url != null) {
							if (document.selection) {
								textarea.focus();
								
								if(selection.text == '') {
									if(text == '')
										selection.text = '[url]'  + url + '[/url]';
									else
										selection.text = '[url=' + url + ']' + text + '[/url]';
								} else {
									selection.text = '[url=' + url + ']' + selection.text + '[/url]';			
								}
							} else {
								var length = textarea.val().length;
								var start = textarea[0].selectionStart;
								var end = textarea[0].selectionEnd;
		
								selection = textarea.val().substring(start, end);
								
								var rep;
								
								if(selection == '') {
									if(text == '')
										rep = '[url]' + url + '[/url]';
									else
										rep = '[url=' + url + ']' + text + '[/url]';
								} else {
									rep = '[url=' + url + ']' + selection + '[/url]';
								}
								textarea.val(textarea.val().substring(0, start) + rep + textarea.val().substring(end, length));
			
								textarea[0].scrollTop = scrollTop;
								textarea[0].scrollLeft = scrollLeft;
							}
						}
					}
				});
			}
	
			function addImg(textarea) {
		
				$('body').bModal({
					heading: 'Inserir Imagem',
					body: {
						'URL': {
							placeHolder: 'http://'
						}
					},
					callback: function (body) {
						
						var url = body['URL'].value;
						
						var scrollTop = textarea.scrollTop;
						var scrollLeft = textarea.scrollLeft;

						var selection;

						if (url != '' && url != null) {

							if (document.selection) {
								textarea.focus();
								selection = document.selection.createRange();
								selection.text = '[img]' + url + '[/img]';
							} else {
								var length = textarea.val().length;
								var start = textarea[0].selectionStart;
								var end = textarea[0].selectionEnd;

								selection = textarea.val().substring(start, end);

								var rep = '[img]' + url + '[/img]';
								textarea.val(textarea.val().substring(0, start) + rep + textarea.val().substring(end, length));

								textarea[0].scrollTop = scrollTop;
								textarea[0].scrollLeft = scrollLeft;
							}
						}
					}
				});
		
		
				
			}
	
			function addList(open, close, textarea) {
				var selection;
				if (document.selection) {
					textarea.focus();
					selection = document.selection.createRange();
					var list = selection.text.split('\n');
		
					for(var i = 0; i < selection.length; i++)
						list[i] = '[*]' + list[i];

					selection.text = open + '\n' + list.join("\n") + '\n' + close;
				} else {
					var length = textarea.val().length;
					var start = textarea[0].selectionStart;
					var end = textarea[0].selectionEnd;
		
					var scrollTop = textarea[0].scrollTop;
					var scrollLeft = textarea[0].scrollLeft;
		
					selection = textarea.val().substring(start, end);
		
					var list = selection.split('\n');
		
					for(var i = 0; i < list.length; i++) 
						list[i] = '[*]' + list[i];
		
					var rep = open + '\n' + list.join("\n") + '\n' + close;
					textarea.val(textarea.val().substring(0, start) + rep + textarea.val().substring(end, length));
		
					textarea[0].scrollTop = scrollTop;
					textarea[0].scrollLeft = scrollLeft;
				}
			}
	
			function addSimpleTag(tag, textarea) {
				var selection;
				if (document.selection) {
					textarea.focus();
					selection = document.selection.createRange();
					selection.text = selection.text + '\n' + tag + '\n';
				} else {
					var length = textarea.val().length;
					var start = textarea[0].selectionStart;
					var end = textarea[0].selectionEnd;
		
					var scrollTop = textarea[0].scrollTop;
					var scrollLeft = textarea[0].scrollLeft;
		
					selection = textarea.val().substring(start, end);
			
					var rep = selection + '\n' + tag + '\n';
					textarea.val(textarea.val().substring(0, start) + rep + textarea.val().substring(end, length));
					textarea[0].scrollTop = scrollTop;
					textarea[0].scrollLeft = scrollLeft;
				}
			}
	
			return self;
		},
		bModal: function (o) {
		
			var div = $('<div>').appendTo('body');
			var html = '<div class="modal" id="bModal"><div class="modal-header"><a class="close" data-dismiss="modal">&times;</a>' +
			'<h3>#Heading#</h3></div><div class="modal-body">' +
			'#Body#</div><div class="modal-footer">' +
			'<a href="#" class="btn btn-primary" id="bModalBtnOk">Ok</a>' +
			'<a href="#" class="btn" data-dismiss="modal">Cancelar</a></div></div>';

			var defaults = {
				heading: 'Modal',
				body:'',
				callback : null
			};

			var options = $.extend(defaults, o);
			
			var body = options.body;
			var content = body;
			
			if(body instanceof Object) {
				content = '<div class="form-horizontal">';
				var c = 0;
				for(var i in body) {
					body[i].id = new Date().getTime() +'-'+ c++;
					content += '<div class="control-group"><label class="control-label" for="'+ body[i].id +'">'+ i +'</label><div class="controls"><input type="text" id="'+ body[i].id +'" placeholder="'+ body[i].placeHolder +'" class="input-xlarge" /></div></div>';
				}
				content += '</div>';
			}
			
			html = html.replace('#Heading#', options.heading).replace('#Body#', content);
			$(div).html(html);
			$(div).modal('show').on('hidden', function() {
				$(div).remove();
			});
			
			$('#bModalBtnOk', this).click(function() {
				if(body instanceof Object) {
					for(var i in body) {
						body[i].value = $('#'+ body[i].id, div).val();
					}
				}
				
				if(options.callback != null)
					options.callback(body);
				$(div).modal('hide');
			});
		}
	});
})(jQuery);


$('#Content').bbcode();