axios.interceptors.request.use((config) => 
{
    if ($("#frmLoadingScreen").length == 0)
    {
      $('#page-content').append(`
        <div id="frmLoadingScreen" style="
          display:    block;
          position:   fixed;
          z-index:    9999;
          top:        0;
          left:       0;
          height:     100%;
          width:      100%;
          background-color: rgba( 255, 255, 255, .8 );
        ">
          <center style="padding: 10% 0; color:#000; font-size:35px;">
            <i class="fa fa-spinner fa-2x fa-spin"></i>
              <strong>Carregando...</strong>
          </center>
        </div>
      `)
    }
    return config
}, (error) => 
{
    if ($("#frmLoadingScreen").length !== 0)
    {
      $("#frmLoadingScreen").remove()
    }
    return Promise.reject(error)
})
  
axios.interceptors.response.use((response) => 
{
    if ($("#frmLoadingScreen").length !== 0)
    {
      $("#frmLoadingScreen").remove()
    }
    return response
}, (error) => 
{
    if ($("#frmLoadingScreen").length !== 0)
    {
      $("#frmLoadingScreen").remove()
    }
    return Promise.reject(error)
})
  
$(document).on(
{
    ajaxStart: function()
    {
        if ($("#frmLoadingScreen").length == 0)
        {
            $('#page-content').append(`
                <div id="frmLoadingScreen" style="
                display:    block;
                position:   fixed;
                z-index:    9999;
                top:        0;
                left:       0;
                height:     100%;
                width:      100%;
                background-color: rgba( 255, 255, 255, .8 );
                ">
                <center style="padding: 10% 0; color:#000; font-size:35px;">
                    <i class="fa fa-spinner fa-2x fa-spin"></i>
                    <strong>Carregando...</strong>
                </center>
                </div>
            `)
        }
    },
    ajaxStop: function()
    {
        if ($("#frmLoadingScreen").length !== 0)
        {
            $("#frmLoadingScreen").remove()
        }
    }
})