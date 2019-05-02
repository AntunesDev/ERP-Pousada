$(document).on('click', '.segment_type', (e) => {
    let selected_li = $(e.currentTarget);

    let data = new FormData()
    data.append('selected', selected_li.attr("type"))
    
    axios.post('SegmentType/change',data)
    .then((res) => {
        if ('erro' in res.data)
            console.error(res.data.erro)
        else
        {
            selected_li.parent("ul").find("i").appendTo(selected_li.find("a"))
            location.reload(true);
        }
    })
})