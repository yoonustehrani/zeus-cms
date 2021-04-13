import React, { Component } from 'react'
import Dropzone from "dropzone"

export default class Uploader extends Component {
    componentDidMount() {
        //dropzone
        Dropzone.autoDiscover = false
        let myDropzone = new Dropzone("#dropzoneTarget", {
            createImageThumbnails: true,
            clickable: true,
            acceptedFiles: ".jpeg, .jpg, .png, .svg, .gif",
            addRemoveLinks: true,
        })
        myDropzone.on("success", response => {
            let NewResults = this.props.files.unshift(...response.data) 
            this.props.setNewResults(NewResults)
        })
    }
    
    render() {
        return (
            <div className="col-lg-8 float-right remove-sm-padding uploader-container">
                <form action="/" id="dropzoneTarget" className="dropzone"></form>
            </div>
        )
    }
}
