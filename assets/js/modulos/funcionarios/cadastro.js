axios.post('Usuarios/listarUsuarios')
.then((res) => 
{
  if (res.data.success)
  {
    res.data.result.forEach(element =>
    {
      $('#fnc_usario').append($('<option>', {value:element.usr_id, text:element.usr_name}))
    })
  }
})

$(document).ready(() => 
{
  let columns =
  {
    "columns":
    [
      {"data": "fnc_id"},
      {"data": "fnc_nome"},
      {"data": "fnc_rg"},
      {"data": "fnc_cpf"},
      {"data": "fnc_telefone"},
      {"data": "fnc_email"},
      {"data": "fnc_endereco"},
      {"data": "fnc_cep"},
      {"data": "fnc_cidade"},
      {"data": "fnc_funcao"},
      {"data": "fnc_salario"}
    ],
    "aoColumnDefs":
    [
      { 'bSortable': false, 'aTargets': null },
    ]
  }

  funcionarioDataTable = new DataTableClass('#funcionario-datatable', 'Funcionarios/consultarFuncionarios')
  funcionarioDataTable.loadTable(columns)

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
    $('#fnc_id').val(0)
  })

  $(`#fnc_id`).on("change", () => 
  {
    if ($(`#fnc_id`).val().length > 0)
    {
      let data = new FormData()
      data.append('fnc_id', $(`#fnc_id`).val())
      axios.post(`Funcionarios/consultarFuncionario`, data)
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

  $(`#funcionario-datatable`).on('click', 'tr', (event) => {
    let id = $(event.currentTarget).find('td:eq(0)').text()
    $(`#fnc_id`)
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
            if (!data.has('fnc_id') && $('#fnc_id').val() != 0)
                data.append('fnc_id', $(`#fnc_id`).val())

            if ($('#fnc_id').val() == 0)
            {
                axios.post(`Funcionarios/incluirFuncionario`, data)
                .then((res) => {
                if (res.data.success == true)
                {
                    swal("Sucesso!", res.data.message, "success")
                    .then(() => {
                    $(`#funcionario-datatable`).DataTable().ajax.reload()
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
                axios.post(`Funcionarios/alterarFuncionario`, data)
                .then((res) => {
                if (res.data.success == true)
                {
                    swal("Sucesso!", res.data.message, "success")
                    .then(() => {
                    $(`#funcionario-datatable`).DataTable().ajax.reload()
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
        data.append('fnc_id', $(`#fnc_id`).val())
        axios.post(`Funcionarios/excluirFuncionario`, data)
        .then((res) => {
          if (res.data.success == true)
          {
            swal("Sucesso!", res.data.message, "success")
            .then(() => {
              $(`#funcionario-datatable`).DataTable().ajax.reload()
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
  