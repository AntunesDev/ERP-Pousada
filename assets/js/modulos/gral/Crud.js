function CrudClass(Controller, Table, Form, identityField, radioFields, eventTriggeringFields, btnSave, btnReset, btnDelete)
{
  $(`#${btnSave}`).prop("disabled", true)
  $(`#${btnDelete}`).prop("disabled", true)

  $('.crud-integer').on('input', (e) => {
    let val = $(e.currentTarget).val()
    if (val.length > 0)
    {
      let last_char = val.substr(val.length-1, val.length)
      if (last_char.match(/[0-9]+/) === null || $.isNumeric(val) == false)
      {
        $(e.currentTarget).val(val.substr(0, val.length - 1))
      }
    }
  })

  $('.crud-float').on('input', (e) => {
    let val = $(e.currentTarget).val()
    if (val.length > 0)
    {
      let last_char = val.substr(val.length-1, val.length)
      if (last_char.match(/[0-9,]+/) === null || $.isNumeric(val.replace(",",".")) == false)
      {
        $(e.currentTarget).val(val.substr(0, val.length - 1))
      }
    }
  })

  $(`#${Form}`).on('reset', () => {
    $('.form-group').each(() => {$(this).removeClass('has-error')})
    $('.help-block').each(() => {$(this).remove()})
  })

  $(`#${btnReset}`).on('click', () => {
    $(`#${Form}`).trigger("reset")
    $(`#${identityField}`).prop('readonly', false)
    $(`#${btnSave}`).prop("disabled", true)
    $(`#${btnDelete}`).prop("disabled", true)
  })

  $(`#${identityField}`).on("change paste blur", () => {
    if ($(`#${identityField}`).val().length > 0)
    {
      let data = new FormData()
      data.append('id', $(`#${identityField}`).val())
      axios.post(`${Controller}/getObjectPrimaryKey`, data)
      .then((res) => {
        if (res.data.success == true)
        {
          $(`#${identityField}`).prop('readonly', true)

          Object.keys(res.data.result).map((key) => {
            let value = res.data.result[key]
            if (radioFields != null && radioFields.indexOf(key) != -1)
            {
              $(`input[name=${key}][value="${value}"]`).prop('checked', true)
            }
            else
            {
              $(`#${key}`).val(value)
            }

            if (eventTriggeringFields != null && key in eventTriggeringFields)
            {
              $(`#${key}`).trigger(eventTriggeringFields[key])
            }

            $(`#${Form}`).change()
          })
        }
      })
      $(`#${btnSave}`).prop("disabled", false)
      $(`#${btnDelete}`).prop("disabled", false)
    }
    else
    {
      $(`#${btnSave}`).prop("disabled", true)
      $(`#${btnDelete}`).prop("disabled", true)
    }
  })

  $(`#${Table}`).on('click', 'tr', (event) => {
    let id = $(event.currentTarget).find('td:eq(0)').text()
    $(`#${identityField}`)
      .val(id)
      .focus()
      .trigger("blur")
      .prop('readonly', true)
  })

  $(`#${btnSave}`).on('click', () => {
    if (!$(`#${Form}`)[0].checkValidity())
      $('<input type="submit">').hide().appendTo($(`#${Form}`)).click().remove();
    else
    {
      let valid = true

      let inputs = $(`#${Form} :input`)
      inputs.each((k,v) => {
        if ($(v).attr('readonly'))
        {
          if ($(v).attr('required'))
          {
            if ($(v).val().length == 0)
            {
              valid = false
              return valid
            }
          }
        }
      })

      if (valid)
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
            let data = new FormData($(`#${Form}`)[0])
            if (!data.has(identityField))
              data.append(identityField, $(`#${identityField}`).val())
    
            axios.post(`${Controller}/saveOrUpdateData`, data)
            .then((res) => {
              if (res.data.success == true)
              {
                swal("Sucesso!", res.data.message, "success")
                .then(() => {
                  $(`#${Table}`).DataTable().ajax.reload()
                  $(`#${btnReset}`).click()
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
      }
      else 
      {
        swal("Oops...", "Ocorreu um erro ao validar o formulário.", "error")
      }
    }
  })

  $(`#${btnDelete}`).on('click', () => {
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
        data.append('id', $(`#${identityField}`).val())
        axios.post(`${Controller}/deleteData`, data)
        .then((res) => {
          if (res.data.success == true)
          {
            swal("Sucesso!", res.data.message, "success")
            .then(() => {
              $(`#${Table}`).DataTable().ajax.reload()
              $(`#${btnReset}`).click()
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

}
