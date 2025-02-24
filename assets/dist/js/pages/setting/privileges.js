let grid;

const tableGridID = "#group-grid";
const tableGrid = $(tableGridID);
const groupForm = $('#group-form');
const groupModal = $('#group-modal');
const groupMenu = $("#menu-tree");

const groupJs = (() => {
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
			groupJs.editData(data);
		});

    table.on("click", "tbody div.delete-data", function () {
			var data = table.row($(this).parents("tr")).data();
			groupJs.deleteData(data);
		});

    table.on("change", "tbody input.change_is_active", function (e) {
			var data = table.row($(this).parents("tr")).data();
			var checked = this.checked;
			groupJs.updateStatus(data, checked);
		});

		table.on("click", "tbody div.edit-menu", function () {
			var data = table.row($(this).parents("tr")).data();
			groupJs.editMenus(data);
		});

    return table;
  }

  const handleForm = function() {
    groupForm.validate({
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
          data: groupForm.serialize(),
          dataType: 'json',
          success: (response) => {
            const { metadata } = response;
            Swal.fire({
              title: metadata.status ? "Berhasil" : "Gagal",
              html: metadata.message,
              icon: metadata.status ? "success" : "warning",
            }).then((result) => {
              if (result.isConfirmed && metadata.status) {
                groupJs.resetForm();
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
		$('a#group-access-tab').on(
			"shown.bs.tab",
			function () {
				DTUtils.refreshData(grid);
			}
		);
  }

	const handleButtons = function() {
		$('#btn-reset').on('click', function(e){
			e.preventDefault();

			groupJs.resetForm();
		});

		$("#menus-save-button").on("click", function (e) {
			e.preventDefault();
			const group_id = $("#priv-id").val();
			if (!group_id)
				return Swal.fire("", "Pilih Salah Satu Group Akses Terlebih Dahulu");

			const selected_data = $("#menu-tree").jstree("get_selected", true);

			let data = [];
			selected_data.forEach(selected => {
				const exist = data.find(s => s.menu_id == selected.parent);
				if(selected.parent != '#' && !exist){
					data.push({
						menu_id: selected.parent,
						privilege_id: group_id,
						is_selected: 0,
					})
				}

				const child = selected.children;
				const is_selected = child.length ? 0 : 1;
				const existChils = data.find(s => s.menu_id == selected.id)
				if(!existChils){
					data.push({
						menu_id: selected.id,
						privilege_id: group_id,
						is_selected,
					})
				}
			});

			const menu_id = data.map((item) => item.menu_id);

			$.cajax({
				url: `${pageUrl}/save_menu`,
				method: "POST",
				data: { data, group_id, menu_id },
				dataType: 'json',
				success: (response) => {
					const { metadata } = response;
					Swal.fire({
						title: metadata.status ? "Berhasil" : "Gagal",
						html: metadata.message,
						icon: metadata.status ? "success" : "warning",
					});

					if (metadata.status) groupModal.modal("hide");
				},
			});
		});
	}

	const handleTree = () => {
		groupMenu.jstree({
			plugins: ["checkbox"],
			core: {
				data: {
					url: `${pageUrl}/menutree`,
					method: "POST",
					data: function (node) {
						const group_id = $("#priv-id").val();
						return { id: node.id, group_id };
					},
				},
			},
		});

		groupMenu.on("loaded.jstree", function () {
			groupMenu.jstree("open_all");
		});
	};

	const handleModal = () => {
		groupModal.on("hide.bs.modal", () => {
			groupJs.resetForm();
			groupMenu.jstree("destroy").empty();
		});

		groupModal.on("shown.bs.modal", () => {
			handleTree();
		});
	}

  return {
    init: function() {
      grid = handleDataTable();
      handleTabs();
      handleForm();
			handleButtons();
			handleModal();
    },
    resetForm: function() {
      $("#priv-id").val("");
			groupForm.trigger("reset");
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
    },
		editMenus: function(data) {
			const { id } = data;
			$("#priv-id").val(id);
			groupModal.modal('show');
		}
  }
})();

Cignadlte.onDOMContentLoaded(() => {
  groupJs.init();
});