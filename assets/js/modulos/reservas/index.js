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

    if ($('#rsv_id').val() != 0)
      formData.append('rsv_id', $('#rsv_id').val())

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
      {
        data: null, render: (data, type, row) => 
        {
          let rsv_status = data.rsv_status
          let sst_nome = data.sst_nome
          sst_nome
          return `<center><button class='btn btn-warning btnStatus' rsv_id='${data.rsv_id}' rsv_status='${rsv_status}'>${sst_nome}</button></center>`
        }
      },
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

  $(`#cancelar-btn`).prop("disabled", true)

  $(`#cadastro-form`).on('reset', () => 
  {
    $('.form-group').each(() => {$(this).removeClass('has-error')})
    $('.help-block').each(() => {$(this).remove()})
  })

  $(`#limpar-btn`).on('click', () => 
  {
    $(`#cadastro-form`).trigger("reset")
    $(`#cancelar-btn`).prop("disabled", true)
    $('#rsv_id').val(0)
    $('#rsv_status').val(0)
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

          if (res.data.result.rsv_status != 1)
          {
            $('#rsv_data_entrada').attr('readonly', false)
            $('#rsv_data_saida').attr('readonly', false)
          }
          else
          {
            $('#rsv_data_entrada').removeAttr('readonly')
            $('#rsv_data_saida').removeAttr('readonly')
          }
        }
      })
      $(`#cancelar-btn`).prop("disabled", false)
    }
    else
    {
      $(`#cancelar-btn`).prop("disabled", true)
    }
  })

  $(`#reservas-datatable`).on('click', 'td', (event) => 
  {
    if (event.currentTarget != $(event.currentTarget).parent().find('td:eq(4)')[0])
    {
      let id = $(event.currentTarget).parent().find('td:eq(0)').text()
      $(`#rsv_id`)
      .val(id)
      .trigger("change")
    }
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

  $(document).on('click', '.btnStatus', (e) => 
  {
    target = $(e.currentTarget)
    rsv_id = target.attr('rsv_id')
    rsv_status = target.attr('rsv_status')

    switch (rsv_status)
    {
      case '1':
        message = "Ainda não é o dia de entrada dessa reserva. É necessário alterar o perído antes."
        error = true
        break;
      case '2':
        message = "Efetuar check-in do cliente para esta reserva?"
        rsv_status_to = 3
        error = false
        break;
      case '3':
        message = "Adiantar o checkout para esta reserva?"
        rsv_status_to = 5
        error = false
        break;
      case '4':
        message = "Realizar o checkout para esta reserva?"
        rsv_status_to = 5
        error = false
        break;
    }

    if (error)
    {
      swal("Oops...", message, "error")
    }
    else
    {
      swal({
        title: "Tem certeza?",
        text: message,
        icon: "warning",
        buttons: true,
        dangerMode: true
      })
      .then((sure) => {
        if (sure)
        {
          let formData = new FormData()
          formData.append("rsv_id", rsv_id)
          formData.append("rsv_status_from", rsv_status)
          formData.append("rsv_status_to", rsv_status_to)
          axios.post("Reservas/alterarEstadoReserva", formData)
          .then((res) =>
          {
            if (res.data.success)
            {
              if (typeof res.data.itens != "undefined")
              {
                let innerHTML = "<table width=100%>"
                res.data.itens.forEach((item, index) =>
                {
                  innerHTML += `
                  <tr>
                    <td align=left>${item.cns_produto}</td>
                    <td align=right>${item.cns_qtde}</td>
                    <td align=right>x R$ ${item.cns_valor}</td>
                  </tr>
                  <tr>
                    <td colspan=3 align=right>R$ ${item.cns_valor_total}</td>
                  </tr>
                  `

                  if (index != (res.data.itens.length - 1))
                  {
                    innerHTML += `
                    <tr>
                      <td></td>
                      <td colspan=2 align=right><hr></td>
                    </tr>
                    `
                  }
                })
                innerHTML += "<tr><th colspan=3><hr></th></tr>"
                innerHTML += `<tr><th>Total</th><th colspan=2 align=right>R$ ${res.data.valor_total}</th></tr>`
                innerHTML += "</table>"

                var span = document.createElement("span");
                span.innerHTML = innerHTML

                swal(
                {
                  title: 'Realize a cobrança ao cliente!',
                  closeOnClickOutside: false,
                  closeOnEsc: false,
                  button: false,
                  content: span
                })

                setTimeout(() =>
                {
                  swal(
                  {
                    title: 'Realize a cobrança ao cliente!',
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    button: true,
                    content: span
                  })
                  .then(() =>
                  {
                    $(`#reservas-datatable`).DataTable().ajax.reload()
                    $(`#limpar-btn`).click()
                  })
                }, 6500)
              }
              else
              {
                swal("Sucesso!", res.data.message, "success")
                .then(() =>
                {
                  $(`#reservas-datatable`).DataTable().ajax.reload()
                  $(`#limpar-btn`).click()
                })
              }
            }
            else
            {
              swal("Oops...", res.data.message, "error")
            }
          })
        }
      })
    }
  })

  $(`#cancelar-btn`).on('click', () => 
  {
    swal({
      title: "Tem certeza?",
      text: "Cancelar a reserva selecionada?",
      icon: "warning",
      buttons: true,
      dangerMode: true
    })
    .then((sure) => {
      if (sure) {
        let data = new FormData()
        data.append('rsv_id', $(`#rsv_id`).val())
        axios.post(`Reservas/cancelarReserva`, data)
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
  