$(document).ready(() => 
{
  let columns =
  {
    "columns":
    [
      {"data": "ste_id"},
      {"data": "ste_tipo"},
      {"data": "ste_valor"}
    ],
    "aoColumnDefs":
    [
      { 'bSortable': false, 'aTargets': null },
    ]
  }

  suiteDataTable = new DataTableClass('#suite-datatable', 'Suites/consultarSuites')
  suiteDataTable.loadTable(columns)


  $(`#delete-btn`).prop("disabled", true)

  $(`#cadastro-form`).on('reset', () => 
  {
    $('.form-group').each(() => {$(this).removeClass('has-error')})
    $('.help-block').each(() => {$(this).remove()})
  })

  $(`#limpar-btn`).on('click', () => 
  {
    $(`#cadastro-form`).trigger("reset")
    $(`#delete-btn`).prop("disabled", true)
    $('#ste_id').val(0)
  })

  $(`#ste_id`).on("change", () => 
  {
    if ($(`#ste_id`).val().length > 0)
    {
      let data = new FormData()
      data.append('ste_id', $(`#ste_id`).val())
      axios.post(`Suites/buscarSuite`, data)
      .then((res) => {
        if (res.data.success == true)
        {
          Object.keys(res.data.result).map((key) => {
            let value = res.data.result[key]
            $(`#${key}`).val(value)
            $(`#cadastro-form`).change()
          })
        }
      })
      $(`#delete-btn`).prop("disabled", false)
    }
    else
    {
      $(`#delete-btn`).prop("disabled", true)
    }
  })

  $(`#suite-datatable`).on('click', 'tr', (event) => {
    let id = $(event.currentTarget).find('td:eq(0)').text()
    $(`#ste_id`)
      .val(id)
      .trigger("change")
  })

  $(`#add-btn`).on('click', () => {
    if (!$(`#cadastro-form`)[0].checkValidity())
      $('<input type="submit">').hide().appendTo($(`#cadastro-form`)).click().remove();
    else
    {
        swal({
            title: "Tem certeza?",
            text: "Salvar as informações especificadas?",
            icon: "warning",
            buttons: ["Não", "Sim"],
            dangerMode: true
        })
        .then((sure) => {
            if (sure) {
            let data = new FormData($(`#cadastro-form`)[0])
            if (!data.has('ste_id') && $('#ste_id').val() != 0)
              data.append('ste_id', $(`#ste_id`).val())

            if ($('#ste_id').val() == 0)
            {
                axios.post(`Suites/incluirSuite`, data)
                .then((res) => {
                if (res.data.success == true)
                {
                    swal("Sucesso!", res.data.message, "success")
                    .then(() => {
                    $(`#suite-datatable`).DataTable().ajax.reload()
                    $(`#limpar-btn`).click()
                    })
                }
                else
                {
                    swal("Oops...", res.data.message, "error")
                }
                })
            }
            else
            {
                axios.post(`Suites/alterarSuite`, data)
                .then((res) => {
                if (res.data.success == true)
                {
                    swal("Sucesso!", res.data.message, "success")
                    .then(() => {
                    $(`#suite-datatable`).DataTable().ajax.reload()
                    $(`#limpar-btn`).click()
                    })
                }
                else
                {
                    swal("Oops...", res.data.message, "error")
                }
                })
            }
            } else {
            swal.close()
            }
        })
    }
  })

  $(`#delete-btn`).on('click', () => {
    swal({
      title: "Tem certeza?",
      text: "Excluir o item selecionado?",
      icon: "warning",
      buttons: ["Não", "Sim"],
      dangerMode: true
    })
    .then((sure) => {
      if (sure) {
        let data = new FormData()
        data.append('ste_id', $(`#ste_id`).val())
        axios.post(`Suites/excluirSuite`, data)
        .then((res) => {
          if (res.data.success == true)
          {
            swal("Sucesso!", res.data.message, "success")
            .then(() => {
              $(`#suite-datatable`).DataTable().ajax.reload()
              $(`#limpar-btn`).click()
            })
          }
          else
          {
            swal("Oops...", res.data.message, "error")
          }
        })
      } else {
        swal.close()
      }
    })
  })

  $('#print-btn').on('click', () =>
  {
    swal("Oops...", "Função ainda em testes.", "error")
  })

})
  