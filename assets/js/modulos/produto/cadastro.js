$(document).ready(() => 
{
  let columns =
  {
    "columns":
    [
      {"data": "prd_id"},
      {"data": "prd_descricao"},
      {"data": "prd_valor"}
    ],
    "aoColumnDefs":
    [
      { 'bSortable': false, 'aTargets': null },
    ]
  }

  produtoDataTable = new DataTableClass('#produto-datatable', 'Produtos/consultarProdutos')
  produtoDataTable.loadTable(columns)

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
    $('#prd_id').val(0)
  })

  $(`#prd_id`).on("change", () => 
  {
    if ($(`#prd_id`).val().length > 0)
    {
      let data = new FormData()
      data.append('prd_id', $(`#prd_id`).val())
      axios.post(`Produtos/buscarProduto`, data)
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

  $(`#produto-datatable`).on('click', 'tr', (event) => {
    let id = $(event.currentTarget).find('td:eq(0)').text()
    $(`#prd_id`)
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
            buttons: true,
            dangerMode: true
        })
        .then((sure) => {
            if (sure) {
            let data = new FormData($(`#cadastro-form`)[0])
            if (!data.has('prd_id') && $('#prd_id').val() != 0)
                data.append('prd_id', $(`#prd_id`).val())

            if ($('#prd_id').val() == 0)
            {
                axios.post(`Produtos/incluirProduto`, data)
                .then((res) => {
                if (res.data.success == true)
                {
                    swal("Sucesso!", res.data.message, "success")
                    .then(() => {
                    $(`#produto-datatable`).DataTable().ajax.reload()
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
                axios.post(`Produtos/alterarProduto`, data)
                .then((res) => {
                if (res.data.success == true)
                {
                    swal("Sucesso!", res.data.message, "success")
                    .then(() => {
                    $(`#produto-datatable`).DataTable().ajax.reload()
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
      buttons: true,
      dangerMode: true
    })
    .then((sure) => {
      if (sure) {
        let data = new FormData()
        data.append('prd_id', $(`#prd_id`).val())
        axios.post(`Produtos/excluirProduto`, data)
        .then((res) => {
          if (res.data.success == true)
          {
            swal("Sucesso!", res.data.message, "success")
            .then(() => {
              $(`#produto-datatable`).DataTable().ajax.reload()
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
  