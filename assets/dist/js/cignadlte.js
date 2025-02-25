"use strict"

const Cignadlte = function() {
  if (typeof $.fn.dataTable !== "undefined")
		$.fn.dataTable.Api.register("column().title()", function () {
			return $(this.header()).data("id")
		})
  
  return {
    init: () => {
			setTimeout(function () {
				if (window.___browserSync___ === undefined && Number(localStorage.getItem('Cignadlte:Demo:MessageShowed')) < Date.now()) {
					localStorage.setItem('Cignadlte:Demo:MessageShowed', (Date.now()) + (15 * 60 * 1000))
					
					Swal.fire("Welcome to Cignadlte (Codeigniter + AdminLTE)", "This is only for CI 3 and use AdminLTE v3.2.0 for the template, but you can use any template you want.<br><br>Have fun!<br><br><small>If you want to remove this. Well I guess you already know where to go. but if you dont, then, you can remove it on assets/dist/js/cignadlte.js.</small>")
				}
			}, 1000)
    },
    onDOMContentLoaded:function(e){"loading"===document.readyState?document.addEventListener("DOMContentLoaded",e):e()},
		setManualSelect2: (id_select2, id, text) => {
			var option = new Option(text, id, true, true);
			$(id_select2).append(option).trigger('change');
      $(id_select2).trigger({
        type: 'select2:select',
        params: {
          data: { id, text }
        }
      });
		},
  }
}()

$(document).ready(function() { 
  Cignadlte.init()
})