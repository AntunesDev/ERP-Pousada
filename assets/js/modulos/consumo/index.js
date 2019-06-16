if (rsv_id == 'null')
{
  swal("Oops...", "Não é possível acrescentar produtos sem ter uma reserva selecionada.", "error")
  .then(() =>
  {
    window.location.href = 'Reservas'
  })
}
else
{
  $('#cns_reserva').val(rsv_id)
}

axios.post('/ERP-Pousada/Produtos/listarProdutos')
.then((res) => 
{
  $('#cns_produto').append($('<option>', {value:0, text: "Selecione um produto", preco: ''}))
  res.data.result.forEach(element =>
  {
    $('#cns_produto').append($('<option>', {value:element.prd_id, text:element.prd_descricao, preco: element.prd_valor}))
  })
})

$(document).ready(() =>   
{
  let columns =
  {
    "columns":
    [
      {"data": "cns_produto"},
      {"data": "prd_descricao"},
      {"data": "cns_valor"},
      {"data": "cns_qtde"},
      {"data": "cns_valor_total"},
      {"data": "cns_momento"}
    ],
    "aoColumnDefs":
    [
      { 'bSortable': false, 'aTargets': 4 },
    ]
  }

  consumoDataTable = new DataTableClass('#consumo-datatable', 'Consumo/consultarConsumos', {'cns_reserva': $('#cns_reserva').val()})
  consumoDataTable.loadTable(columns)

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
    $('#cns_produto').val(0)
    $('#cns_valor').val(0)
    $('#cns_qtde').val(0)
  })

  $(`#cns_produto`).on("change", () => 
  {
    if ($(`#cns_produto`).val().length > 0)
    {
      let data = new FormData()
      data.append('cns_reserva', $('#cns_reserva').val())
      data.append('cns_produto', $(`#cns_produto`).val())
      axios.post(`/ERP-Pousada/Consumo/buscarConsumo`, data)
      .then((res) => {
        let prd_valor = $('#cns_produto :selected').attr('preco')
        $('#cns_valor').val(prd_valor)

        if (res.data.success == true)
        {
          Object.keys(res.data.result).map((key) => {
            let value = res.data.result[key]
            $(`#${key}`).val(value)
            $(`#cadastro-form`).change()
          })
          $('#cns_valor_total').val(+$('#cns_valor').val() * + $('#cns_qtde').val())
        }
        else
        {
          $('#cns_qtde').val(0)
          $('#cns_valor_total').val(0)
        }
      })
      $(`#delete-btn`).prop("disabled", false)
    }
    else
    {
      $(`#delete-btn`).prop("disabled", true)
    }
  })

  $(`#consumo-datatable`).on('click', 'tr', (event) => {
    let id = $(event.currentTarget).find('td:eq(0)').text()
    $(`#cns_produto`)
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
            if (!data.has('cns_produto') && $('#cns_produto').val() != 0)
              data.append('cns_produto', $(`#cns_produto`).val())
            if (!data.has('cns_reserva') && $('#cns_reserva').val() != 0)
              data.append('cns_reserva', $('#cns_reserva').val())

            if ($('#cns_produto').val() == 0)
            {
                axios.post(`/ERP-Pousada/Consumo/incluirConsumo`, data)
                .then((res) => {
                if (res.data.success == true)
                {
                    swal("Sucesso!", res.data.message, "success")
                    .then(() => {
                      $(`#consumo-datatable`).DataTable().ajax.reload()
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
                axios.post(`/ERP-Pousada/Consumo/alterarConsumo`, data)
                .then((res) => {
                if (res.data.success == true)
                {
                    swal("Sucesso!", res.data.message, "success")
                    .then(() => {
                      $(`#consumo-datatable`).DataTable().ajax.reload()
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
        data.append('cns_produto', $(`#cns_produto`).val())
        data.append('cns_reserva', $('#cns_reserva').val())
        axios.post(`/ERP-Pousada/Consumo/excluirConsumo`, data)
        .then((res) => {
          if (res.data.success == true)
          {
            swal("Sucesso!", res.data.message, "success")
            .then(() => {
              $(`#consumo-datatable`).DataTable().ajax.reload()
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

  $('#voltar-btn').on('click', () =>
  {
    window.location.href = '/ERP-Pousada/Reservas'
  })

  $('#cns_qtde').on('change', () =>
  {
    $('#cns_valor_total').val(+$('#cns_valor').val() * + $('#cns_qtde').val())
  })

})
  