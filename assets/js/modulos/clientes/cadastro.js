$(document).ready(() => 
{
  let columns =
  {
    "columns":
    [
      {"data": "cli_id"},
      {"data": "cli_nome"},
      {"data": "cli_rg"},
      {"data": "cli_cpf"},
      {"data": "cli_telefone"},
      {"data": "cli_email"},
      {
        data: null, render: (data, type, row) => {
          if (data.reservas == 0)
          {
            return `<center><i class="fa fa-ban text-danger"></i></center>`
          }
          else
          {
            return `<center><i class="fa fa-check" style="color: green;"></i></center>`
          }
        }
      }
    ],
    "aoColumnDefs":
    [
      { 'bSortable': false, 'aTargets': [6] },
    ]
  }

  clienteDataTable = new DataTableClass('#cliente-datatable', 'Clientes/consultarClientes')
  clienteDataTable.loadTable(columns)


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
    $('#cli_id').val(0)
  })

  $(`#cli_id`).on("change", () => 
  {
    if ($(`#cli_id`).val().length > 0)
    {
      let data = new FormData()
      data.append('cli_id', $(`#cli_id`).val())
      axios.post(`Clientes/consultarCliente`, data)
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

  $(`#cliente-datatable`).on('click', 'tr', (event) => {
    let id = $(event.currentTarget).find('td:eq(0)').text()
    $(`#cli_id`)
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
            if (!data.has('cli_id') && $('#cli_id').val() != 0)
                data.append('cli_id', $(`#cli_id`).val())

            if ($('#cli_id').val() == 0)
            {
                axios.post(`Clientes/incluirCliente`, data)
                .then((res) => {
                if (res.data.success == true)
                {
                    swal("Sucesso!", res.data.message, "success")
                    .then(() => {
                    $(`#cliente-datatable`).DataTable().ajax.reload()
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
                axios.post(`Clientes/alterarCliente`, data)
                .then((res) => {
                if (res.data.success == true)
                {
                    swal("Sucesso!", res.data.message, "success")
                    .then(() => {
                    $(`#cliente-datatable`).DataTable().ajax.reload()
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
        data.append('cli_id', $(`#cli_id`).val())
        axios.post(`Clientes/excluirCliente`, data)
        .then((res) => {
          if (res.data.success == true)
          {
            swal("Sucesso!", res.data.message, "success")
            .then(() => {
              $(`#cliente-datatable`).DataTable().ajax.reload()
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
  