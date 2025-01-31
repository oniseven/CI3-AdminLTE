let grid;

const tableGridID = "#main-grid";
const tableGrid = $(tableGridID);
const mainForm = $('#main-form');
const mainModal = $('#main-modal');

const mainJs = (() => {
  const handleDataTable = function() {
    const table = tableGrid.DataTable({
      dom: `<'row'<'col-sm-6'l><'col-sm-6'p>>
            <'row'<'col-sm-12'tr>>
			      <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'p>>`,
			scrollY: "40vh",
			scrollX: true,
			scrollCollapse: true,
			lengthMenu: [10, 25, 50],
			pageLength: 10,
      searchDelay: 500,
			processing: true,
			serverSide: true,
      ajax: {
				url: `${pageUrl}/datatable`,
				type: "POST",
				data: {
					columnDefs: [
						{ value: "id", type: "num" },
						{ value: "name", type: "string" },
						{ value: "menu", type: "num" },
						{ value: "is_active", type: "num" },
					],
				},
				error: function (xhr, error, code) {
					checkAjaxCustomError(xhr, error)
				},
			},
      columns: [
				{ data: "id" },
				{ data: "name" },
				{ data: "menu" },
				{ data: "is_active" },
				{ data: "actions", responsivePriority: -1 },
			],
      order: [[1, "asc"]],
      columnDefs: [
				{ className: "text-center", targets: [0, 2] },
				{
					targets: [2],
					orderable: false,
					searchable: false,
					render: (data, type, full, meta) => {
						return `
              <div class="btn btn-success btn-icon btn-sm edit-menu" data-id="${full.id}">
                <i class="fas fa-plus"></i>
              </div>
            `;
					},
				},
				{
					targets: [3],
					className: "text-center",
					render: (data, type, full, meta) => {
						const is_checked = +data;
						const inputID = `is_active_${full.id}`;
						return DTUtils.toggleCheckbox(inputID, is_checked);
					},
				},
				{
					targets: -1,
					className: "text-center",
					orderable: false,
					searchable: false,
					render: (data, type, full, meta) => DTUtils.editDeleteButton(full),
				},
			],
    });

    return table;
  }

  const handleForm = function() {
    mainForm.validate({
      rules: {
        name: {
          required: true,
        }
      },
      messages: {
        name: {
          required: "Masukkan nama group hak akses"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function(form) {
        Swal.fire("Asdfasf");
        // some other code
        // maybe disabling submit button
        // then:
        // $(form).submit();
      }
    })
  }

  const handleTabs = function() {
    $('a[data-bs-toggle="tab"][href="#group-access"]').on(
			"shown.bs.tab",
			function () {
        console.log('asdfasdf');
				DTUtils.refreshData(grid);
			}
		);
  }

  return {
    init: function() {
      grid = handleDataTable();
      handleTabs();
      handleForm();
    },
    edit: function() {
      
    },
    delete: function() {

    }
  }
})();

Cignadlte.onDOMContentLoaded(() => {
  mainJs.init();
})