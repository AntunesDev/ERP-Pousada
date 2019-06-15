axios.post('Clientes/listarClientes')
.then((res) => 
{
  res.data.result.forEach(element =>
  {
    $('#rsv_cliente').append($('<option>', {value:element.cli_id, text:element.cli_nome}))
  })
})

$(document).on('change', '#rsv_data_entrada, #rsv_data_saida', () =>
{
  let rsv_data_entrada = $('#rsv_data_entrada').val()
  let rsv_data_saida = $('#rsv_data_saida').val()

  if(rsv_data_entrada.length > 0 && rsv_data_saida.length > 0)
  {
    let formData = new FormData()
    formData.append("rsv_data_entrada", rsv_data_entrada)
    formData.append("rsv_data_saida", rsv_data_saida)
    axios.post("Reservas/getSuitesDisponiveis", formData)
    .then((res) =>
    {
      $('#rsv_suite').html($('<option>', {value:0, text:"Selecione uma suíte..."}))
      if (res.data.success)
      {
        res.data.list.forEach(element =>
        {
          $('#rsv_suite').append($('<option>', {value:element.ste_id, text:element.ste_tipo}))
        })
        $('#rsv_suite').removeAttr('readonly')
      }
      else
      {
        $('#rsv_suite').attr('readonly', true)
      }
    })
  }
  else
  {
    $('#rsv_suite').attr('readonly', true)
    $('#rsv_suite').html($('<option>', {value:0, text:"Selecione uma suíte..."}))
  }
})

$(document).ready(() =>   
{
  let columns =
  {
    "columns":
    [
      {"data": "rsv_id"},
      {"data": "rsv_data_entrada"},
      {"data": "rsv_data_saida"},
      {"data": "ste_tipo"},
      {"data": "sst_nome"},
      /*{
        data: null, render: (data, type, row) => {
          if (data.usr_nome.length == 0)
          {
            return `<center><i class="fa fa-ban text-danger"></i></center>`
          }
          else
          {
            return `<center>${data.usr_nome}</center>`
          }
        }
      },*/
      {"data": "cli_nome"},
      {"data": "fnc_nome"},
      {"data": "rsv_valor_total"}
    ],
    "aoColumnDefs":
    [
      { 'bSortable': false, 'aTargets': 6 },
    ]
  }

  reservasDataTable = new DataTableClass('#reservas-datatable', 'Reservas/consultarReservas')
  reservasDataTable.loadTable(columns)

  $(document).on('keypress', (e) =>
  {
    if (e.keyCode == 13)
    {
      $('#add-btn').click()
    }
  })

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
    $('#rsv_id').val(0)
  })

  $(`#rsv_id`).on("change", () => 
  {
    if ($(`#rsv_id`).val().length > 0)
    {
      let data = new FormData()
      data.append('rsv_id', $(`#rsv_id`).val())
      axios.post(`Reservas/buscarReserva`, data)
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

  $(`#reservas-datatable`).on('click', 'tr', (event) => {
    let id = $(event.currentTarget).find('td:eq(0)').text()
    $(`#rsv_id`)
      .val(id)
      .trigger("change")
  })

  $(`#add-btn`).on('click', () => {
    if (!$(`#cadastro-form`)[0].checkValidity())
      $('<input type="submit">').hide().appendTo($(`#cadastro-form`)).click().remove();
    else
    {
      if ($('#rsv_suite').val() == 0)
      {
        swal("Oops...", "Selecione uma suíte.", "error")
      }
      else
      {
        swal({
          title: "Tem certeza?",
          text: "Salvar as informações especificadas?",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((sure) => {
          if (sure) {
            let data = new FormData($(`#cadastro-form`)[0])
            if (!data.has('rsv_id') && $('#rsv_id').val() != 0)
              data.append('rsv_id', $(`#rsv_id`).val())

            if ($('#rsv_id').val() == 0)
            {
              axios.post(`Reservas/incluirReserva`, data)
              .then((res) => {
                if (res.data.success == true)
                {
                  swal("Sucesso!", res.data.message, "success")
                  .then(() => {
                    $(`#reservas-datatable`).DataTable().ajax.reload()
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
              axios.post(`Reservas/alterarReserva`, data)
              .then((res) => {
                if (res.data.success == true)
                {
                  swal("Sucesso!", res.data.message, "success")
                  .then(() => {
                    $(`#reservas-datatable`).DataTable().ajax.reload()
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
    }
  })

  $(`#delete-btn`).on('click', () => {
    swal({
      title: "Tem certeza?",
      text: "Excluir o item selecionado?",
      icon: "warning",
      buttons: true,
      dangerMode: true
    })
    .then((sure) => {
      if (sure) {
        let data = new FormData()
        data.append('rsv_id', $(`#rsv_id`).val())
        axios.post(`Reservas/excluirReserva`, data)
        .then((res) => {
          if (res.data.success == true)
          {
            swal("Sucesso!", res.data.message, "success")
            .then(() => {
              $(`#reservas-datatable`).DataTable().ajax.reload()
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

})
  