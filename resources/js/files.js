import React from 'react'
import ReactDOM from 'react-dom'
import ReactFiles from './components/react-files'

//dropzone
import Dropzone from "dropzone"
Dropzone.autoDiscover = false
let myDropzone = new Dropzone("#dropzoneTarget", {
    createImageThumbnails: true,
    clickable: true,
    acceptedFiles: ".jpeg, .jpg, .png, .svg, .gif",
    addRemoveLinks: true
})
myDropzone.on("addedfile", file => {
    console.log(`File added: ${file.name}`)
})


const target = document.getElementById("react-files")

if (target) {
    ReactDOM.render(
        <ReactFiles/>
    , target)
}
