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
					Swal.fire({
            title: 'Terjadi Kesalahan',
            text: 'Terjadi kesalahan saat memproses request',
            icon: "error",
            confirmButtonText: "OK",
          });
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
        { targets: [0], orderable: false, searchable: false },
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

    DTUtils.drawNumber(table);

    table.on("click", "tbody div.edit-data", function () {
			var data = table.row($(this).parents("tr")).data();
			mainJs.editData(data);
		});

    table.on("click", "tbody div.delete-data", function () {
			var data = table.row($(this).parents("tr")).data();
			mainJs.deleteData(data);
		});

    table.on("change", "tbody input.change_is_active", function (e) {
			var data = table.row($(this).parents("tr")).data();
			var checked = this.checked;
			mainJs.updateStatus(data, checked);
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
        $.cajax({
          url: `${pageUrl}/save_data`,
          method: "POST",
          data: mainForm.serialize(),
          dataType: 'json',
          success: (response) => {
            const { metadata } = response;
            Swal.fire({
              title: metadata.status ? "Berhasil" : "Gagal",
              html: metadata.message,
              icon: metadata.status ? "success" : "warning",
            }).then((result) => {
              if (result.isConfirmed && metadata.status) {
                mainJs.resetForm();
              }
            });
          },
        }).always((xhr) => {
          if (xhr.status !== 401 && xhr.status !== 403)
            DTUtils.refreshData(grid);
        });
      }
    })
  }

  const handleTabs = function() {
    $('a[data-bs-toggle="tab"][href="#group-access"]').on(
			"shown.bs.tab",
			function () {
				DTUtils.refreshData(grid);
			}
		);
  }

	const handleButtons = function() {
		$('#btn-reset').on('click', function(e){
			e.preventDefault();

			mainJs.resetForm();
		})
	}

  return {
    init: function() {
      grid = handleDataTable();
      handleTabs();
      handleForm();
			handleButtons();
    },
    resetForm: function() {
      $("#priv-id").val("");
			mainForm.trigger("reset");
    },
    editData: function(data) {
      const { id, name, is_active } = data;
			$("#priv-id").val(+id);
			$("#name").val(name);
			$("#status").prop("checked", +is_active);
    },
    deleteData: function(data) {
      Swal.fire({
				title: `Yakin Ingin Menghapus Data ${data.name}?`,
				text: "Data tidak bisa dikembalikan apabila telah dihapus!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes",
			}).then((result) => {
				if (result.isConfirmed) {
					$.cajax({
						url: `${pageUrl}/delete_data`,
						method: "POST",
						data: {
							id: data.id,
						},
						dataType: 'json',
						success: (response) => {
							const { metadata } = response;
							Swal.fire({
								title: metadata.status ? "Berhasil" : "Gagal",
								html: metadata.message,
								icon: metadata.status ? "success" : "warning",
							});
						},
					}).always((xhr) => {
						if (xhr.status !== 401 && xhr.status !== 403)
							DTUtils.refreshData(grid);
					});
				}
			});
    },
    updateStatus: function(data, checked) {
			const statusText = checked ? 'Aktif' : 'Tidak Aktif';
			Swal.fire({
				title: `Yakin Ingin Mengubah Status Data menjadi ${statusText}?`,
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes",
			}).then((result) => {
				if (result.isConfirmed) {
					$.cajax({
						url: `${pageUrl}/update_status`,
						method: "POST",
						data: {
							id: data.id,
							checked: checked ? 1 : 0
						},
						dataType: 'json',
						success: (response) => {
							const { metadata } = response;
							Swal.fire({
								title: metadata.status ? "Berhasil" : "Gagal",
								html: metadata.message,
								icon: metadata.status ? "success" : "warning",
							});
						},
					}).always((xhr) => {
						if (xhr.status !== 401 && xhr.status !== 403)
							DTUtils.refreshData(grid);
					});
				}
			});
    }
  }
})();

Cignadlte.onDOMContentLoaded(() => {
  mainJs.init();
});