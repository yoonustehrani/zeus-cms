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
            let NewResults = this.props.files.unshift(...response.data) 
            this.props.setNewResults(NewResults)
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
