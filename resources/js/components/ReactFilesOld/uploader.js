import React, { Component } from 'react'
import Dropzone from "dropzone"

export default class Uploader extends Component {
    componentDidMount() {
        //dropzone
        let token = document.head.querySelector('meta[name="csrf-token"]')
        Dropzone.autoDiscover = false
        let myDropzone = new Dropzone("#dropzoneTarget", {
            url: this.props.uploadUrl,
            createImageThumbnails: true,
            clickable: true,
            acceptedFiles: ".jpeg, .jpg, .png, .svg, .gif",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': token.content
            }
        })
        myDropzone.on("success", response => {
            let { created_at, ext, id, name, path, thumbnail_path, type, updated_at } = JSON.parse(response.xhr.responseText)
            let newResults = this.props.files
            newResults.unshift({
                id: id,
                name: name,
                ext: ext,
                path: path,
                thumbnail_path: thumbnail_path,
                type: type,
                created_at: created_at,
                updated_at: updated_at
            }) 
            this.props.setNewResults(newResults)
        })
    }
    
    render() {
        return (
            <div className="col-lg-8 float-right remove-sm-padding uploader-container">
                <form id="dropzoneTarget" className="dropzone"></form>
            </div>
        )
    }
}
