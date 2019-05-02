$('.pop').on('click', (e) =>
{
	if ($('#viewImage').attr('src') != "#")
	{
		$('.imagepreview').attr('src', $(e.currentTarget).find('img').attr('src'))
		$('#imagemodal').modal('show')
	}
	else
	{
		$('#modal-info-content').html("Sem imagem para mostrar")
		$('#modal-info').click()
	}
})

let fileListImage = new Array

Dropzone.options.myAwesomeDropzone = 
{
	acceptedFiles: ".jpeg,.jpg",
	addRemoveLinks: true,
	dictDefaultMessage: 'Arraste os arquivos até aqui para enviá-los',
	dictRemoveFile: "Eliminar Foto",
	clickable: true,
	accept: (file, done) =>
	{
		done()
	},
	init: function()
	{
		this.on("addedfile", (file) =>
		{ 
			if(file.size > 819200) // not more than 800kb
			{
				this.removeFile(file) 
				swal("Oops...", `O arquivo "${file.name}" é maior que 800kb`, "error")
			}
		})
		this.on("success", (file, response) =>
		{
			let obj = JSON.parse(response)
			file.previewElement.querySelector("img").alt = obj.imgName
			file.previewElement.querySelector("[data-dz-name]").innerHTML = obj.imgName
			
			fileListImage.push(
			{
				"serverFileName" : response,
				"fileName" : file.name,
				"fileRename" : obj.imgName
			})

			SetNameImage(obj.imgName)
		})
		this.on("removedfile", (file) =>
		{
			let fileRename = JSON.parse(file.xhr.response).imgName
			let formData = new FormData()
			formData.append("fileName", fileRename)
			axios.post('Gral/deleteUploadedFile', formData)

			let addFile = ""
			let listNew = new Array

			for (let f = 0; f < fileListImage.length; f++) 
			{
				if (fileListImage[f].fileRename != fileRename) 
				{
					listNew.push(fileListImage[f])
					
					if (addFile == "")
						addFile = fileListImage[f].fileRename
					else
						addFile = addFile + "," + fileListImage[f].fileRename
				}
			}
			
			fileListImage = listNew
			SetNameListImage(addFile)
		})
	},
	maxfilesexceeded: function(file)
	{
		this.removeAllFiles()
		this.addFile(file)
	}
}