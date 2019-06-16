axios.post('GruposAcessos/consultarGrupos')
.then((res) => 
{
  if (res.data.success)
  {
    $('#usr_grupo').append($('<option>', {value:0, text:'Selecione um grupo'}))
    res.data.result.forEach(element =>
    {
      $('#usr_grupo').append($('<option>', {value:element.grp_id, text:element.grp_nome}))
    })
  }
})

$(document).ready(() => 
{
  let columns =
  {
    "columns":
    [
      {"data": "usr_id"},
      {"data": "usr_name"},
      {"data": "usr_grupo"},
      {
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
      }
    ],
    "aoColumnDefs":
    [
      { 'bSortable': false, 'aTargets': null },
    ]
  }

  usuarioDataTable = new DataTableClass('#usuario-datatable', 'Usuarios/consultarUsuarios')
  usuarioDataTable.loadTable(columns)


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
    $('#usr_id').val(0)
  })

  $(`#usr_id`).on("change", () => 
  {
    if ($(`#usr_id`).val().length > 0)
    {
      let data = new FormData()
      data.append('usr_id', $(`#usr_id`).val())
      axios.post(`Usuarios/buscarUsuario`, data)
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

  $(`#usuario-datatable`).on('click', 'tr', (event) => {
    let id = $(event.currentTarget).find('td:eq(0)').text()
    $(`#usr_id`)
      .val(id)
      .trigger("change")
  })

  $(`#add-btn`).on('click', () => {
    if (!$(`#cadastro-form`)[0].checkValidity())
      $('<input type="submit">').hide().appendTo($(`#cadastro-form`)).click().remove();
    else
    {
      if ($('#usr_grupo').val() == 0)
      {
        swal("Oops...", "Selecione um grupo de acessos.", "error")
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
            if (!data.has('usr_id') && $('#usr_id').val() != 0)
              data.append('usr_id', $(`#usr_id`).val())

            if ($('#usr_id').val() == 0)
            {
              axios.post(`Usuarios/incluirUsuario`, data)
              .then((res) => {
                if (res.data.success == true)
                {
                  swal("Sucesso!", res.data.message, "success")
                  .then(() => {
                    $(`#usuario-datatable`).DataTable().ajax.reload()
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
              axios.post(`Usuarios/alterarUsuario`, data)
              .then((res) => {
                if (res.data.success == true)
                {
                  swal("Sucesso!", res.data.message, "success")
                  .then(() => {
                    $(`#usuario-datatable`).DataTable().ajax.reload()
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
        data.append('usr_id', $(`#usr_id`).val())
        axios.post(`Usuarios/excluirUsuario`, data)
        .then((res) => {
          if (res.data.success == true)
          {
            swal("Sucesso!", res.data.message, "success")
            .then(() => {
              $(`#usuario-datatable`).DataTable().ajax.reload()
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
  